<?php

namespace App\Services;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\PeopleRepository;
use App\Interfaces\Service\PeopleService;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

use App\Interfaces\Service\ReportService;
use App\Models\Locator;
use App\Helpers\Utils;
use App\Models\DocumentsPeople;
use App\Models\ImageProperty;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PeopleServiceImpl implements PeopleService
{
    private $peopleRepository;
    public function __construct(PeopleRepository $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
    }

    public function getLocators(array $data, bool $paginate): Result
    {
        return $this->peopleRepository->getLocators($data, $paginate);
    }

    public function getTotalLocators(): Result
    {
        return $this->peopleRepository->getTotalLocators();
    }

    public function getTotalRenters(): Result
    {
        return $this->peopleRepository->getTotalRenters();
    }


    public function saveLocator(array $input): Result
    {
        return DB::transaction(function () use ($input) {

            if ($input['id_people']) {
                $search_people = $this->peopleRepository->getLocatorByIdPeople($input['id_people']);
                if (!$search_people->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > getLocatorByIdPeople',
                            'Erro ao localizar pessoa',
                            400,
                        )
                    );

                $people_exists = $search_people->getData();
                if ($people_exists)
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveLocator',
                            'Já existe um locador com os dados informados',
                            400,
                        )
                    );
            } else {
                $result_people = $this->peopleRepository->savePeople($input['people']);
                if (!$result_people->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveLocator -> savePeople',
                            'Erro ao salvar pessoa: ' . $result_people->getError()->getMessage(),
                            400,
                        )
                    );
                $id_people = $result_people->getData();
                $input['id_people'] = $id_people;
            }


            $result = $this->peopleRepository->saveLocator($input);
            if (!$result->isSuccess())
                return Result::error(
                    new ErrorApplication(
                        'PeopleService > saveLocator',
                        'Erro ao criar proprietário',
                        400,
                    )
                );


            if (isset($input['documents']) && !empty($input['documents'])) {
                $result_image = $this->saveDocumentsPeople($input, $input['id_people']);
                if (!$result_image->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveLocator > saveDocumentsPeople',
                            'Erro ao salvar imagens no banco de dados',
                            422,
                        )
                    );
            }

            return Result::success();
        });
    }
    public function updateLocator(array $input, string $id_locator): Result
    {
        return DB::transaction(function () use ($input, $id_locator) {

            $result = $this->peopleRepository->updateLocator($input, $id_locator);
            if (!$result->isSuccess())
                return Result::error(
                    new ErrorApplication(
                        'PeopleService > updateLocator',
                        'Erro ao alterar proprietário',
                        400,
                    )
                );


            if (isset($input['documents']) && !empty($input['documents'])) {
                $result_image = $this->saveDocumentsPeople($input, $input['id_people']);
                if (!$result_image->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > updateLocator > saveDocumentsPeople',
                            'Erro ao salvar imagens no banco de dados',
                            422,
                        )
                    );
            }

            return Result::success();
        });
    }
    public function getLocatorById(string $id): Result
    {
        return $this->peopleRepository->getLocatorById($id);
    }

    public function getPeopleByCpf(string $cpf): Result
    {
        return $this->peopleRepository->getPeopleByCpf($cpf);
    }

    public function getPeopleByCnpj(string $cnpj): Result
    {
        return $this->peopleRepository->getPeopleByCnpj($cnpj);
    }


    public function deleteLocator(string $id_locator): Result
    {
        return $this->peopleRepository->deleteLocator($id_locator);
    }
    public function restoreLocator(string $id_locator): Result
    {
        return $this->peopleRepository->restoreLocator($id_locator);
    }



    public function getRenters(array $data, bool $paginate): Result
    {
        return $this->peopleRepository->getRenters($data, $paginate);
    }
    public function saveRenter(array $input): Result
    {
        return DB::transaction(function () use ($input) {
            if ($input['id_people']) {
                $search_people = $this->peopleRepository->getRenterByIdPeople($input['id_people']);
                if (!$search_people->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveLocator',
                            'Erro ao criar pessoa',
                            400,
                        )
                    );

                $people_exists = $search_people->getData();
                if ($people_exists)
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveLocator',
                            'Já existe um locatário com os dados informados',
                            400,
                        )
                    );
            } else {
                $result_people = $this->peopleRepository->savePeople($input['people']);
                if (!$result_people->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveRenter',
                            'Erro ao criar pessoa',
                            400,
                        )
                    );
                $id_people = $result_people->getData();
                $input['id_people'] = $id_people;
            }

            $result = $this->peopleRepository->saveRenter($input);
            if (!$result->isSuccess())
                return Result::error(
                    new ErrorApplication(
                        'PeopleService > saveRenter',
                        'Erro ao salvar locatário',
                        400,
                    )
                );

            if (isset($input['documents']) && !empty($input['documents'])) {
                $result_image = $this->saveDocumentsPeople($input, $input['id_people']);
                if (!$result_image->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveRenter > saveDocumentsPeople',
                            'Erro ao salvar imagens no banco de dados',
                            422,
                        )
                    );
            }

            return Result::success();
        });
    }

    public function updateRenter(array $input, string $id_renter): Result
    {
        return DB::transaction(function () use ($input, $id_renter) {

            $result = $this->peopleRepository->updateRenter($input, $id_renter);
            if (!$result->isSuccess())
                return Result::error(
                    new ErrorApplication(
                        'PeopleService > updateRenter',
                        'Erro ao alterar locatário',
                        400,
                    )
                );


            if (isset($input['documents']) && !empty($input['documents'])) {
                $result_image = $this->saveDocumentsPeople($input, $input['id_people']);
                if (!$result_image->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveRenter > saveDocumentsPeople',
                            'Erro ao salvar imagens no banco de dados',
                            422,
                        )
                    );
            }
            return Result::success();
        });
    }
    public function getRenterById(string $id): Result
    {
        return $this->peopleRepository->getRenterById($id);
    }
    public function deleteRenter(string $id_renter): Result
    {
        return $this->peopleRepository->deleteRenter($id_renter);
    }
    public function restoreRenter(string $id_renter): Result
    {
        return $this->peopleRepository->restoreRenter($id_renter);
    }




    public function getGuarantors(array $data, bool $paginate): Result
    {
        return $this->peopleRepository->getGuarantors($data, $paginate);
    }
    public function saveGuarantor(array $input): Result
    {
        return DB::transaction(function () use ($input) {
            if ($input['id_people']) {
                $search_people = $this->peopleRepository->getGuarantorByIdPeople($input['id_people']);
                if (!$search_people->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveLocator',
                            'Erro ao criar pessoa',
                            400,
                        )
                    );
                $people_exists = $search_people->getData();
                if ($people_exists)
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveLocator',
                            'Já existe um fiador com os dados informados',
                            400,
                        )
                    );
            } else {
                $result_people = $this->peopleRepository->savePeople($input['people']);
                if (!$result_people->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > savePeople',
                            'Erro ao criar pessoa',
                            400,
                        )
                    );
                $id_people = $result_people->getData();
                $input['id_people'] = $id_people;
            }

            $result = $this->peopleRepository->saveGuarantor($input);
            if (!$result->isSuccess())
                return Result::error(
                    new ErrorApplication(
                        'PeopleService > saveGuarantor',
                        'Erro ao salvar fiador',
                        400,
                    )
                );

            if (isset($input['documents']) && !empty($input['documents'])) {
                $result_image = $this->saveDocumentsPeople($input, $input['id_people']);
                if (!$result_image->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveGuarantor > saveDocumentsPeople',
                            'Erro ao salvar imagens no banco de dados',
                            422,
                        )
                    );
            }

            return Result::success();
        });
    }
    public function updateGuarantor(array $input, string $id_guarantor): Result
    {
        return DB::transaction(function () use ($input, $id_guarantor) {

            $result = $this->peopleRepository->updateGuarantor($input, $id_guarantor);
            if (!$result->isSuccess())
                return Result::error(
                    new ErrorApplication(
                        'PeopleService > updateGuarantor',
                        'Erro ao alterar fiador',
                        400,
                    )
                );


            if (isset($input['documents']) && !empty($input['documents'])) {
                $result_image = $this->saveDocumentsPeople($input, $input['id_people']);
                if (!$result_image->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > updateGuarantor > saveDocumentsPeople',
                            'Erro ao salvar imagens no banco de dados',
                            422,
                        )
                    );
            }

            return Result::success();
        });
    }
    public function getGuarantorById(string $id): Result
    {
        return $this->peopleRepository->getGuarantorById($id);
    }
    public function deleteGuarantor(string $id_renter): Result
    {
        return $this->peopleRepository->deleteGuarantor($id_renter);
    }
    public function restoreGuarantor(string $id_renter): Result
    {
        return $this->peopleRepository->restoreGuarantor($id_renter);
    }



    private function saveDocumentsPeople(array $input, string $id_people): Result
    {
        try {
            $this->validateDirectoryImage($id_people);
            foreach ($input['documents'] as $image) {
                $datetime = new DateTime();
                $date_format = $datetime->format('d-m-H-i-s');
                $filename = $image['type'] . '_' . $id_people . "_" . $date_format . ".jpg";
                $explode_image = explode(',', $image['url']);
                $decoded_image = base64_decode($explode_image[1]);
                file_put_contents(DocumentsPeople::IMAGES_FOLDER . $id_people . "/" . $filename, $decoded_image);
                $result = $this->peopleRepository->saveImage($id_people, $id_people, $filename, $image['type']);
                if (!$result->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'PeopleService > saveDocumentsPeople',
                            'Erro ao salvar imagens no banco de dados',
                            422,
                        )
                    );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleService > saveDocumentsPeople',
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
        $base_dir = DocumentsPeople::IMAGES_FOLDER;
        if (!is_dir($base_dir)) {
            error_log("Base directory does not exist: " . $base_dir);
            return;
        }

        $fullPath = rtrim($base_dir, '/') . '/' . ltrim($reference, '/');
        if (!is_dir($fullPath)) {
            if (!mkdir($fullPath, 0755, true)) {
                error_log("Failed to create directory: " . $fullPath);
            } else {
                error_log("Successfully created directory: " . $fullPath);
            }
        }
    }
}
