<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\Repository\PropertyRepository;
use App\Models\ImageProperty;
use App\Models\Property;
use App\Models\Condo;
use Exception;

class PropertyRepositoryImpl implements PropertyRepository
{
    /**
     *
     * @param array $input
     * @return Result
     */
    public function getProperties(array $input, bool $paginate = false): Result
    {
        try {
            $properties = Property::with(['city', 'locator.people', 'condo', 'pictures', 'transaction', 'renter.people']);
            if (isset($input['search'])) {
                $searchTerm = '%' . $input['search'] . '%';
                $properties->where(function ($q) use ($searchTerm) {
                    $q->where('properties.reference', 'LIKE', $searchTerm)
                        ->orWhere('properties.description', 'LIKE', $searchTerm)
                        ->orWhere('properties.address', 'LIKE', $searchTerm)
                        ->orWhere('properties.district', 'LIKE', $searchTerm);
                })
                ->orWhereHas('locator.people', function ($query) use ($input) {
                    $query->where('name', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('surname', 'LIKE', '%' . $input['search'] . '%');
                });
            }

            if (isset($input['status'])) {
                $properties->where('properties.status', $input['status']);
                if ($input['status'] == Property::UNAVAILABLE)
                    $properties->onlyTrashed();
                elseif (in_array($input['status'], [Property::SOLD, Property::RENTED, Property::AVALIABLE]))
                    $properties->withTrashed();
            } else {
                $properties->withTrashed();
            }

            if (!empty($input['purpose']))
                $properties->where('properties.purpose', $input['purpose']);


            if (!empty($input['id_city']))
                $properties->where('properties.id_city', $input['id_city']);

            if (!empty($input['exception']))
                $properties->where('properties.id', '!=', $input['exception']);

            if (!empty($input['limit_properties']))
                $properties->limit($input['limit_properties']);

            if (!empty($input['bedrooms']))
                $properties->where('properties.bedrooms', $input['bedrooms']);

            if (!empty($input['bathrooms']))
                $properties->where('properties.bathrooms', $input['bathrooms']);


            if (!empty($input['min_value']) && $input['min_value'] != '0.00') {
                if ($input['purpose'] == Property::PURPOSE_SALE) {
                    $properties->where('properties.sale_value', '>',  $input['min_value']);
                }
                if ($input['purpose'] == Property::PURPOSE_RENT) {
                    $properties->where('properties.rental_value', '>', $input['min_value']);
                }
            }

            if (!empty($input['max_value']) && $input['max_value'] != '0.00') {
                if ($input['purpose'] == Property::PURPOSE_SALE) {
                    $properties->where('properties.sale_value', '<',  $input['max_value']);
                }
                if ($input['purpose'] == Property::PURPOSE_RENT) {
                    $properties->where('properties.rental_value', '<', $input['max_value']);
                }
            }

            if(isset($input['order'])){
                $properties->orderBy($input['order'], 'asc');
            } else {
                $properties->orderByDesc('properties.id');
            }


            // dd($properties->toSql(), $properties->getBindings());

            $properties = $paginate
                ? $properties->paginate(30)
                : $properties->get();
            return Result::success($properties);
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > queryLocalization',
                    'Erro ao buscar imóveis: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    /**
     *
     * @param array $input
     * @return Result
     */
    public function getTotalProperties(): Result
    {
        try {
            $properties = Property::count();
            return Result::success($properties);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > getTotalProperties',
                    'Erro ao buscar total de imóveis: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param array $input
     * @return Result
     */
    public function saveProperty(array $input): Result
    {
        try {
            $result = Property::create($input);
            $property = Property::where('reference', $input['reference'])->first();
            if (!$property) {
                return Result::error(
                    new ErrorApplication(
                        'SupplierRepositoryImpl > saveSupplier > create',
                        'Não foi possível criar o proprietário',
                        422,
                    )
                );
            }
            return Result::success($property->id);
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

    /**
     *
     * @param array $input
     * @param string $id_property
     * @return Result
     */
    public function updateProperty(array $input, string $id_property): Result
    {
        try {
            $property = Property::where('id', $id_property)->first();
            $property->fill($input);
            $property->update();

            return Result::success([
                'dispatch' => ($input['status'] != $property['status']),
                'previous' => $property['status'],
                'current' => $input['status'],
            ]);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > updateProperty',
                    'Erro ao alterar imóvel: ' . $e->getMessage(),
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
        try {
            $city = Property::where('id', $id_property)->first();
            $city->delete();
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > deleteProperty',
                    'Erro ao remover imóvel: ' . $e->getMessage(),
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
    public function restoreProperty(string $id_property): Result
    {
        try {
            $city = Property::where('id', $id_property)->first();
            $city->restore();
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > restoreProperty',
                    'Erro ao restaurar imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getPropertyById(string $id): Result
    {
        try {
            $property = Property::with(['pictures','locator.people','renter.people'])->where('id', $id)->withTrashed()->first();
            return Result::success($property);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > getPropertyById',
                    'Erro ao buscar imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getPropertiesByIdLocator(string $id): Result
    {
        try {
            $property = Property::with(['pictures', 'locator', 'condo', 'keys', 'broker'])
                ->where('status', Property::AVALIABLE)
                ->where('id_locator', $id)->withTrashed()->get();
            return Result::success($property);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > getPropertiesByIdLocator',
                    'Erro ao buscar imóveis: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param string $reference
     * @return Imovel|null
     */
    public function getPropertyByReference(string $reference): ?Property
    {
        return Property::where('reference', $reference)->withTrashed()->first();
    }

    /**
     *
     * @param string $id
     * @return boolean
     */
    public function pictureExists(string $id): ?bool
    {
        return ImageProperty::where('id_property', $id)->exists();
    }

    // /**
    //  *
    //  * @param string $id_property
    //  * @param boolean $status
    //  * @return void
    //  */
    // private function changeMainPicture(string $id_property, bool $status): void
    // {
    //     ImageProperty::where('id_property', $id_property)->update(['principal' => $status]);
    // }

    // /**
    //  *
    //  * @param string $id_property
    //  * @return ImageProperty|null
    //  */
    // private function getPicturesOfProperty(string $id_property): ?ImageProperty
    // {
    //     return ImageProperty::where('id_property', $id_property)->where('principal', true)->first();
    // }

    // /**
    //  *
    //  * @param array $ids_properties
    //  * @return Collection|null
    //  */
    // private function getPropertiesByArrayOfId(array $ids_properties): ?Collection
    // {
    //     return ImageProperty::whereIn('id', $ids_properties)->get();
    // }

    // /**
    //  *
    //  * @param string $id_property
    //  * @return Result
    //  */
    // private function deleteImageProperty(string $id_property): void
    // {
    //     try {
    //         $city = Property::where('id', $id_property)->first();
    //         $city->delete();
    //     } catch (\Exception $e) {
    //         throw new \Exception($e->getMessage());
    //     }
    // }

    public function setFalseImageProperty(array $input, string $id_property): Result
    {
        try {
            $update_main = ImageProperty::where('id_property', $input['id_property'])
                ->where('principal', true)
                ->update(['principal', false]);
            if (!$update_main)
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepository > setFalseImageProperty',
                        'Não foi possível alterar a imagem principal',
                        400,
                    )
                );
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > updateImageProperty',
                    'Erro ao alterar imagem principal do imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function setTrueImageProperty(array $input, string $id_property): Result
    {
        try {
            $update_main = ImageProperty::where('id', $input['id_imagem_imovel'])
                ->where('principal', false)
                ->update(['principal', true]);
            if (!$update_main)
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepository > setTrueImageProperty',
                        'Nenhuma imagem principal encontrada ',
                        400,
                    )
                );
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > updateImageProperty',
                    'Erro ao alterar imagem principal do imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    public function getCondos(array $input, bool $paginate = false): Result
    {
        try {
            $db = Condo::with(['city'])->orderBy('id');
            if (isset($input['search'])) {
                $db->where('description', 'LIKE', '%' . $input['search'] . '%')
                    ->orWhere('address', 'LIKE', '%' . $input['search'] . '%')
                    ->orWhere('district', 'LIKE', '%' . $input['search'] . '%');
            }

            if (isset($input['status']) && !empty($input['status'])) {
                if ($input['status'] == Condo::INACTIVE)  // inativos
                    $db->onlyTrashed();
                elseif ($input['status'] == Condo::ALL) // todos
                    $db->withTrashed();
            }

            $condos = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($condos);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > getCondos',
                    'Erro ao buscar condomínio/prédios: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function saveCondo(array $input): Result
    {
        try {
            $condo = Condo::create($input);
            if (!$condo) {
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepositoryImpl > saveCondo > create',
                        'Não foi possível criar o condomínio/prédio',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > saveCondo',
                    'Erro ao salvar condomínio/prédio: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateCondo(array $input, string $id_condo): Result
    {
        try {
            $condo = Condo::where('id', $id_condo)->withTrashed()->first();
            $condo->fill($input);
            $condo->update();
            if (!$condo) {
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepositoryImpl > updateCondo >  update',
                        'Não foi possível atualizar o condomínio/prédio',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > updateCondo',
                    'Erro ao atualizar condomínio/prédio: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getCondoById(string $id): Result
    {
        try {
            $condo = Condo::where('id', $id)->withTrashed()->first();
            return Result::success($condo);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > getCondoById',
                    'Erro ao buscar condomínio/prédio: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function deleteCondo(string $id_condo): Result
    {
        try {
            $condo = Condo::with('property')->where('id', $id_condo)->first();
            $properties = $condo->property ?? [];
            if ($properties->isNotEmpty()) {
                return Result::error(
                    new ErrorApplication(
                        'PeopleRepositoryImpl > deleteCondo > property > delete',
                        'Você não pode remover este condomínio, pois há casas cadastradas no mesmo',
                        422,
                    )
                );
            }

            $condo->delete();
            if (!$condo) {
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepositoryImpl > deleteCondo > condo > delete',
                        'Não foi possível remover o condomínio/prédio',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > deleteCondo',
                    'Erro ao excluir condomínio/prédio: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function restoreCondo(string $id_condo): Result
    {
        try {
            $condo = Condo::where('id', $id_condo)->onlyTrashed()->first();
            $condo->restore();
            if (!$condo) {
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepositoryImpl > deleteCondo > condo > delete',
                        'Não foi possível remover o condomínio/prédio',
                        500,
                    )
                );
            }

            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > restoreCondo',
                    'Erro ao restaurar condomínio/prédios: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function saveImage(string $id_property, string $reference, string $filename, int $counter, bool $exists, ?bool $main = false): Result
    {
        try {
            $picture_property = new ImageProperty();
            $picture_property->id_property = $id_property;
            $picture_property->description = $filename;
            $picture_property->folder = ImageProperty::IMAGES_FOLDER . $reference;

            if ($counter == 1 && !$exists || $main)
                $picture_property->main = true;

            $picture_property->save();
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > restoreCondo',
                    'Erro ao restaurar condomínio/prédios: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function deletePictures(array $pictures_id, string $id_property): Result
    {
        try {
            $delete = ImageProperty::whereIn('id', $pictures_id)->where('id_property', $id_property)->delete();
            if (!$delete) {
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepositoryImpl > deletePictures',
                        'Não foi possível remover as imagens',
                        400,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > deletePictures',
                    'Não foi possível remover as imagens: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function updateMainPicture(string $id_picture, string $id_property): Result
    {
        try {
            $update_pictures =  ImageProperty::where('id_property', $id_property)->update(['main' => false]);
            if (!$update_pictures) {
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepositoryImpl > updateMainPicture',
                        'Não foi possível alterar as imagens',
                        400,
                    )
                );
            }
            $update_picture_true =  ImageProperty::where('id', $id_picture)->where('id_property', $id_property)->update(['main' => true]);
            if (!$update_picture_true) {
                return Result::error(
                    new ErrorApplication(
                        'PropertyRepositoryImpl > updateMainPicture',
                        'Não foi possível alterar as imagens',
                        400,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepositoryImpl > updateMainPicture',
                    'Não foi possível alterar as imagens: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function propertyExists(string $id_city): bool
    {
        return Property::where('id_city', $id_city)->exists();
    }
}
