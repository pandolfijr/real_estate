<?php

namespace App\Services;

use App\Events\EmailEvent;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;

use App\Interfaces\Repository\PropertyRepository;
use App\Interfaces\Repository\LocalizationRepository;
use App\Interfaces\Repository\PeopleRepository;

use App\Interfaces\Service\PropertyService;
use App\Models\ImageProperty;

use App\Helpers\Utils;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Exception;
use Illuminate\Support\Facades\Storage;

class PropertyServiceImpl implements PropertyService
{
    protected $propertyRepository;
    protected $cidadesRepository;
    protected $people_repository;
    public function __construct(
        PropertyRepository $propertyRepository,
        LocalizationRepository $cidadesRepository,
        PeopleRepository $people_repository
    ) {
        $this->propertyRepository = $propertyRepository;
        $this->cidadesRepository = $cidadesRepository;
        $this->people_repository = $people_repository;
    }

    /**
     *
     * @param array $input
     * @return Result
     */
    public function getProperties(array $input, bool $paginate = false): Result
    {
        return $this->propertyRepository->getProperties($input, $paginate);
    }

    public function getTotalProperties(): Result
    {
        return $this->propertyRepository->getTotalProperties();
    }

    /**
     *
     * @param array $input
     * @return Result
     */
    public function saveProperty(array $input): Result
    {
        try {
            $reference = $this->generateReference($input['type']) ?? '';

            if (!$reference)
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepository > saveProperty',
                        'Erro ao gerar referência',
                        422,
                    )
                );
            return DB::transaction(function () use ($input, $reference) {
                $input['reference'] =  $reference;
                $input['suites'] = $input['suites'] ?? 0;
                $input['bedroom'] = $input['bedroom'] ?? 0;
                $input['bathroom'] = $input['bathroom'] ?? 0;
                $input['parking_space'] = $input['parking_space'] ?? 0;
                $result = $this->propertyRepository->saveProperty($input);
                if (!$result->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PropertyService > saveProperty',
                            'Erro ao salvar imóvel',
                            400,
                        )
                    );

                $id_property = $result->getData();
                if (isset($input['images']) && !empty($input['images'])) {
                    $result_image = $this->saveImageProperty($input, $id_property);
                    if (!$result_image->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'PeopleService > saveRenter > saveImagePeople',
                                'Erro ao salvar imagens no banco de dados',
                                422,
                            )
                        );
                }

                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > saveProperty',
                    'Erro ao salvar imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getPropertyById(string $id): Result
    {
        return $this->propertyRepository->getPropertyById($id);
    }

    public function getPropertiesByIdLocator(string $id): Result
    {
        return $this->propertyRepository->getPropertiesByIdLocator($id);
    }

    /**
     *
     * @param array $input
     * @param string $id_property
     * @return Result
     */
    public function updateProperty(array $input, string $id_property): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_property) {
                $property = $this->propertyRepository->updateProperty($input, $id_property);

                if (!$property->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PropertyService > updateProperty',
                            'Erro ao alterar imóvel',
                            400,
                        )
                    );

                if ($input['main'])
                    $this->updateMainPicture($input['main'], $input['id']);


                if (isset($input['exclude']) && !empty($input['exclude'])) {
                    $this->deletePictures($input['exclude'], $input['id']);
                }


                if (isset($input['images']) && !empty($input['images'])) {
                    $result_image = $this->saveImageProperty($input, $id_property);
                    if (!$result_image->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'PeopleService > updateProperty > saveImageProperty',
                                'Erro ao salvar imagens no banco de dados',
                                422,
                            )
                        );
                } else {
                    $this->copyImagem($id_property, $input['reference']);
                }

                // $email_data = $property->getData();
                // if ($email_data['dispatch']) $this->enviaEmail($email_data, $id_property);
                return Result::success();
            });
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > saveProperty',
                    'Erro ao salvar imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param string $id_property
     * @return Result
     */
    public function deleteProperty(string $id_property): Result
    {
        return $this->propertyRepository->deleteProperty($id_property);
    }

    /**
     *
     * @param string $id_property
     * @return Result
     */
    public function restoreProperty(string $id_property): Result
    {
        return $this->propertyRepository->restoreProperty($id_property);
    }

    /**
     *
     * @param string $type
     * @return string
     */
    public function generateReference(string $type): string
    {
        $acronym = Utils::getAcronymByPropertyType($type);
        $code = $acronym . random_int(100000, 999999);

        do {
            $exists = false;
            $property = $this->propertyRepository->getPropertyByReference($code);
            if (!empty($property))
                $exists = true;
        } while ($exists);

        return $code;
    }

    /**
     *
     * @param array $email_data
     * @param string $id_property
     * @return void
     */
    private function enviaEmail(array $email_data, string $id_property)
    {
        $property = $this->propertyRepository->getPropertyById($id_property);
        if (!$property->success())
            throw new Exception('Erro ao enviar e-mail');
        $property = $property->getData();
        $data_mail = new \stdClass;
        $data_mail->status_anterior = Utils::statusImovel($email_data['previous']);
        $data_mail->status_atual = Utils::statusImovel($email_data['current']);
        $data_mail->usuario = Auth::user();
        $data_mail->id_property = $property->id;
        $data_mail->reference = $property->reference;
        $data_mail->descricao_imovel = $property->descricao;
        $data_mail->link = getenv('LINK_PROPERTY') . $property->id;
        event(new EmailEvent($data_mail));
    }

    /**
     *
     * @param array $input
     * @param string $id_property
     * @return Result
     */
    private function saveImageProperty(array $input, string $id_property): Result
    {
        try {
            $this->validateDirectoryImage($input['reference']);
            $exists = $this->propertyRepository->pictureExists($id_property);

            $counter = 1;
            foreach ($input['images'] as $image_base64) {
                $datetime = new DateTime();
                $date_format = $datetime->format('d-m-H-i-s');
                $filename = $input['reference'] . "_" . $date_format . '_' . $counter . ".jpg";
                $explode_image = explode(',', $image_base64);
                $decoded_image = base64_decode($explode_image[1]);
                file_put_contents(ImageProperty::IMAGES_FOLDER . $input['reference'] . "/" . $filename, $decoded_image);
                $this->propertyRepository->saveImage($id_property, $input['reference'], $filename, $counter, $exists);
                $counter++;
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleService > saveImagePeople',
                    'Erro ao salvar imagens no banco de dados: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    /**
     *
     * @param string $reference
     * @return void
     */
    private function validateDirectoryImage(string $reference): void
    {
        if (!is_dir(ImageProperty::IMAGES_FOLDER . $reference))
            mkdir(ImageProperty::IMAGES_FOLDER . $reference, 0755, true);
    }

    private function copyImagem($id_property, $reference)
    {
        $this->validateDirectoryImage($reference);

        $origem = public_path(ImageProperty::SETTINGS_FOLDER . "1/logo_imobiliaria.jpg");
        $destino = public_path(ImageProperty::IMAGES_FOLDER . $reference . "/logo_imobiliaria.jpg");

        if (file_exists($origem)) {
            if (copy($origem, $destino)) {
                $this->propertyRepository->saveImage($id_property, $reference, 'logo_imobiliaria.jpg', 0, false, true);
            }
        }
    }

    private function deletePictures(array $id_pictures, string $id_property)
    {
        $this->propertyRepository->deletePictures($id_pictures, $id_property);
    }


    private function updateMainPicture(string $id_picture, string $id_property)
    {
        $this->propertyRepository->updateMainPicture($id_picture, $id_property);
    }




    public function updateImageProperty(array $input, string $id_property): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_property) {
                $result_set_false = $this->propertyRepository->setFalseImageProperty($input, $id_property);
                if (!$result_set_false->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PropertyRepository > updateImageProperty',
                            'Erro ao remover imagem principal',
                            500,
                        )
                    );

                $result_set_true = $this->propertyRepository->setTrueImageProperty($input, $id_property);
                if (!$result_set_true->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PropertyRepository > updateImageProperty',
                            'Erro ao alterar imagem principal',
                            500,
                        )
                    );
                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > saveProperty',
                    'Erro ao salvar imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getCondos(array $data, bool $paginate = false): Result
    {
        return $this->propertyRepository->getCondos($data, $paginate);
    }
    public function saveCondo(array $input): Result
    {
        return $this->propertyRepository->saveCondo($input);
    }
    public function updateCondo(array $input, string $id_renter): Result
    {
        return $this->propertyRepository->updateCondo($input, $id_renter);
    }
    public function getCondoById(string $id): Result
    {
        return $this->propertyRepository->getCondoById($id);
    }
    public function deleteCondo(string $id_renter): Result
    {
        return $this->propertyRepository->deleteCondo($id_renter);
    }
    public function restoreCondo(string $id_renter): Result
    {
        return $this->propertyRepository->restoreCondo($id_renter);
    }

    public function propertyExists(string $id_city): bool
    {
        return $this->propertyRepository->propertyExists($id_city);
    }
}
