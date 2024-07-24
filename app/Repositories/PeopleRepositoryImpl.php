<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\PeopleRepository;
use App\Models\Guarantor;
use App\Models\DocumentsPeople;
use App\Models\Locator;
use App\Models\People;
use App\Models\Property;
use App\Models\Renter;
use Exception;

use Illuminate\Support\Facades\DB;

class PeopleRepositoryImpl implements PeopleRepository
{
    public function getLocators(array $input, bool $paginate): Result
    {
        try {
            $db = Locator::with(['people', 'property', 'transaction'])->orderBy('id');
            if (isset($input['search'])) {
                $db->whereHas('people', function ($query) use ($input) {
                    $query->where('name', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('email', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('cellphone', 'LIKE', '%' . $input['search'] . '%');
                });
            }

            if (isset($input['status']) && !empty($input['status'])) {
                if ($input['status'] == Locator::INACTIVE)
                    $db->onlyTrashed();
                elseif ($input['status'] == Locator::ALL)
                    $db->withTrashed();
            }

            $locators = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($locators);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getLocators',
                    'Erro ao buscar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function savePeople(array $input): Result
    {
        try {
            $people = People::insertGetId($input);
            if (!$people) {
                return Result::error(
                    new ErrorApplication(
                        'PeopleRepositoryImpl > savePeople > people > create',
                        'Não foi possível criar a pessoa',
                        500,
                    )
                );
            }
            return Result::success($people);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > savePeople',
                    'Erro ao criar pessoa: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function saveLocator(array $input): Result
    {
        try {
            $locator = Locator::create($input);
            if (!$locator) {
                return Result::error(
                    new ErrorApplication(
                        'PeopleRepositoryImpl > saveLocator > locator > create',
                        'Não foi possível criar o proprietário',
                        500,
                    )
                );
            }
            return Result::success($locator);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > saveLocator',
                    'Erro ao salvar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateLocator(array $input, string $id_locator): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_locator) {
                $people = People::where('id', $input['people']['id'])->withTrashed()->first();
                $people->fill($input['people']);
                $people->update();
                if (!$people) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > updateLocator > people > update',
                            'Não foi possível atualizar o proprietário',
                            500,
                        )
                    );
                }
                unset($input['people']);
                $locator = Locator::where('id', $id_locator)->withTrashed()->first();
                $locator->fill($input);
                $locator->update();
                if (!$locator) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > updateLocator > locator > update',
                            'Não foi possível atualizar o proprietário',
                            500,
                        )
                    );
                }
                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > updateLocator',
                    'Erro ao atualizar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getLocatorById(string $id): Result
    {
        try {
            $locator = Locator::where('id', $id)->with('people.documents', 'property')->withTrashed()->first();
            return Result::success($locator);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getLocatorById',
                    'Erro ao buscar locadore: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getPeopleByCpf(string $cpf): Result
    {
        try {
            $people = People::select('id', 'name', 'surname', 'cpf', 'rg', 'cellphone', 'email', 'address', 'complement', 'number', 'marital_status', 'birth_date', 'district', 'id_city', 'cep')->where('cpf', $cpf)->first();
            return Result::success($people);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getPeopleById',
                    'Erro ao buscar pessoa por CPF: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getLocatorByIdPeople(string $cpf): Result
    {
        try {
            $locator = Locator::where('id_people', $cpf)->first();
            return Result::success($locator);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getLocatorByIdPeople',
                    'Erro ao buscar pessoa id: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getGuarantorByIdPeople(string $cpf): Result
    {
        try {
            $guarantor = Guarantor::where('id_people', $cpf)->first();
            return Result::success($guarantor);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getGuarantorByIdPeople',
                    'Erro ao buscar pessoa id: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getRenterByIdPeople(string $cpf): Result
    {
        try {
            $renter = Renter::where('id_people', $cpf)->first();
            return Result::success($renter);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getRenterByIdPeople',
                    'Erro ao buscar pessoa id: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    public function deleteLocator(string $id_locator): Result
    {
        try {
            return DB::transaction(function () use ($id_locator) {
                $locator = Locator::with('property')->where('id', $id_locator)->first();
                $id_people = $locator->id_people;
                $properties = $locator->property ?? [];

                if ($properties->isNotEmpty()) {
                    foreach ($properties as $property) {
                        $property_to_delete = Property::where('id', $property['id'])->first();

                        if (in_array($property_to_delete->status, [Property::SOLD, Property::RENTED])) {
                            return Result::error(
                                new ErrorApplication(
                                    'PeopleRepositoryImpl > deleteLocator > property > delete',
                                    'Você não pode remover este proprietário, pois o mesmo possui imóvel alugado/vendido',
                                    422,
                                )
                            );
                        }
                        $delete = $property_to_delete->delete();
                        if (!$delete) {
                            return Result::error(
                                new ErrorApplication(
                                    'PeopleRepositoryImpl > deleteLocator > property > delete',
                                    'Não foi possível remover o imóvel deste proprietário',
                                    422,
                                )
                            );
                        }
                    }
                }
                $locator->delete();
                if (!$locator) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > deleteLocator > locator > delete',
                            'Não foi possível remover o proprietário',
                            422,
                        )
                    );
                }

                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > deleteLocator',
                    'Erro ao excluir proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function restoreLocator(string $id_locator): Result
    {
        try {
            return DB::transaction(function () use ($id_locator) {
                $locator = Locator::where('id', $id_locator)->onlyTrashed()->first();
                $id_people = $locator->id_people;
                $people = People::where('id', $id_people)->onlyTrashed()->first();

                $people->restore();
                if (!$people) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > deleteLocator > people > delete',
                            'Não foi possível remover o proprietário',
                            500,
                        )
                    );
                }

                $locator->restore();
                if (!$locator) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > deleteLocator > locator > delete',
                            'Não foi possível remover o proprietário',
                            500,
                        )
                    );
                }

                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > restoreLocator',
                    'Erro ao restaurar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    private function getNextId(): string
    {
        $lastId = People::withTrashed()->max('id');
        return $lastId ? $lastId + 1 : 1;
    }

    // ###################################################################################################### //


    public function getRenters(array $input, bool $paginate): Result
    {
        try {
            $db = Renter::with(['people', 'transaction'])->orderBy('id');
            if (isset($input['search'])) {
                $db->whereHas('people', function ($query) use ($input) {
                    $query->where('name', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('email', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('cellphone', 'LIKE', '%' . $input['search'] . '%');
                });
            }

            if (isset($input['status']) && !empty($input['status'])) {
                if ($input['status'] == Renter::INACTIVE)
                    $db->onlyTrashed();
                elseif ($input['status'] == Renter::ALL)
                    $db->withTrashed();
            }

            $locators = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($locators);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getRenters',
                    'Erro ao buscar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function saveRenter(array $input): Result
    {
        try {
            $renter = Renter::create($input);
            if (!$renter) {
                return Result::error(
                    new ErrorApplication(
                        'PeopleRepositoryImpl > saveRenter > locator > create',
                        'Não foi possível criar o proprietário',
                        500,
                    )
                );
            }
            return Result::success($renter->toArray());
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > saveRenter',
                    'Erro ao salvar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateRenter(array $input, string $id_renter): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_renter) {
                $people = People::where('id', $input['people']['id'])->withTrashed()->first();
                $people->fill($input['people']);
                $people->update();
                if (!$people) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > updateRenter > people > update',
                            'Não foi possível atualizar o proprietário',
                            500,
                        )
                    );
                }
                unset($input['people']);
                $renter = Renter::where('id', $id_renter)->withTrashed()->first();
                $renter->fill($input);
                $renter->update();
                if (!$renter) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > updateRenter > renter > update',
                            'Não foi possível atualizar o proprietário',
                            500,
                        )
                    );
                }
                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > updateRenter',
                    'Erro ao atualizar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getRenterById(string $id): Result
    {
        try {
            $renter = Renter::where('id', $id)->with(['transaction.property', 'transaction.locator.people', 'people.documents'])->withTrashed()->first();
            return Result::success($renter);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getRenterById',
                    'Erro ao buscar locadore: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function deleteRenter(string $id_renter): Result
    {
        try {
            return DB::transaction(function () use ($id_renter) {

                $renter = Renter::where('id', $id_renter)->first();
                $id_people = $renter->id_people;
                $renter->delete();
                if (!$renter) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > deleteRenter > renter > delete',
                            'Não foi possível remover o proprietário',
                            500,
                        )
                    );
                }
                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > deleteRenter',
                    'Erro ao excluir proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function restoreRenter(string $id_renter): Result
    {
        try {
            return DB::transaction(function () use ($id_renter) {
                $renter = Renter::where('id', $id_renter)->onlyTrashed()->first();
                $id_people = $renter->id_people;
                $people = People::where('id', $id_people)->onlyTrashed()->first();

                $people->restore();
                if (!$people) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > deleteRenter > people > delete',
                            'Não foi possível remover o proprietário',
                            500,
                        )
                    );
                }


                $renter->restore();
                if (!$renter) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > deleteRenter > renter > delete',
                            'Não foi possível remover o proprietário',
                            500,
                        )
                    );
                }

                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > restoreRenter',
                    'Erro ao restaurar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    // ######################################################################################### //

    // ###################################################################################################### //


    public function getGuarantors(array $input, bool $paginate): Result
    {
        try {
            $db = Guarantor::with('people')->orderBy('id');
            if (isset($input['search'])) {
                $db->whereHas('people', function ($query) use ($input) {
                    $query->where('name', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('email', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('cellphone', 'LIKE', '%' . $input['search'] . '%');
                });
            }

            if (isset($input['status']) && !empty($input['status'])) {
                if ($input['status'] == Guarantor::INACTIVE)  // inativos
                    $db->onlyTrashed();
                elseif ($input['status'] == Guarantor::ALL) // todos
                    $db->withTrashed();
            }

            $guarantors = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($guarantors);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getGuarantors',
                    'Erro ao buscar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function saveGuarantor(array $input): Result
    {
        try {
            $guarantor = Guarantor::create($input);
            if (!$guarantor) {
                return Result::error(
                    new ErrorApplication(
                        'PeopleRepositoryImpl > saveGuarantor > guarantor > create',
                        'Não foi possível criar o proprietário',
                        400,
                    )
                );
            }
            return Result::success($guarantor->toArray());
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > saveGuarantor',
                    'Erro ao salvar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateGuarantor(array $input, string $id_guarantor): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_guarantor) {
                $people = People::where('id', $input['people']['id'])->withTrashed()->first();
                $people->fill($input['people']);
                $people->update();
                if (!$people) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > updateGuarantor > people > update',
                            'Não foi possível atualizar o proprietário',
                            500,
                        )
                    );
                }
                unset($input['people']);
                $guarantor = Guarantor::where('id', $id_guarantor)->withTrashed()->first();
                $guarantor->fill($input);
                $guarantor->update();
                if (!$guarantor) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > updateGuarantor > guarantor > update',
                            'Não foi possível atualizar o proprietário',
                            500,
                        )
                    );
                }
                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > updateGuarantor',
                    'Erro ao atualizar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getGuarantorById(string $id): Result
    {
        try {
            $guarantor = Guarantor::where('id', $id)->with(['people.documents'])->withTrashed()->first();
            return Result::success($guarantor);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > getGuarantorById',
                    'Erro ao buscar locadore: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function deleteGuarantor(string $id_guarantor): Result
    {
        try {
            return DB::transaction(function () use ($id_guarantor) {
                $guarantor = Guarantor::where('id', $id_guarantor)->first();
                $id_people = $guarantor->id_people;
                $guarantor->delete();
                if (!$guarantor) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > deleteGuarantor > guarantor > delete',
                            'Não foi possível remover o proprietário',
                            500,
                        )
                    );
                }
                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > deleteGuarantor',
                    'Erro ao excluir proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function restoreGuarantor(string $id_guarantor): Result
    {
        try {
            return DB::transaction(function () use ($id_guarantor) {
                $guarantor = Guarantor::where('id', $id_guarantor)->onlyTrashed()->first();
                $id_people = $guarantor->id_people;
                $people = People::where('id', $id_people)->onlyTrashed()->first();

                $people->restore();
                if (!$people) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > deleteGuarantor > people > delete',
                            'Não foi possível remover o proprietário',
                            500,
                        )
                    );
                }

                $guarantor->restore();
                if (!$guarantor) {
                    return Result::error(
                        new ErrorApplication(
                            'PeopleRepositoryImpl > deleteGuarantor > guarantor > delete',
                            'Não foi possível remover o proprietário',
                            500,
                        )
                    );
                }

                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepositoryImpl > restoreGuarantor',
                    'Erro ao restaurar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getTotalLocators(): Result
    {
        try {
            $locators = Locator::count();
            return Result::success($locators);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepository > getTotalLocators',
                    'Erro ao buscar total de Proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    public function getTotalRenters(): Result
    {
        try {
            $renters = Renter::count();
            return Result::success($renters);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PeopleRepository > getTotalRenters',
                    'Erro ao buscar total de Locatários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    /**
     *
     * @param string $id
     * @return boolean
     */
    public function imageExists(string $id): ?bool
    {
        return DocumentsPeople::where('id_people', $id)->exists();
    }

    /**
     * Undocumented function
     *
     * @param string $id_property
     * @param string $reference
     * @param string $filename
     * @param integer $counter
     * @param boolean $exists
     * @param boolean|null $main
     * @return Result
     */
    public function saveImage(string $id_people, string $reference, string $filename, string $type): Result
    {
        try {
            $image_people = new DocumentsPeople();
            $image_people->id_people = $id_people;
            $image_people->description = $filename;
            $image_people->type_document= $type;
            $image_people->folder = DocumentsPeople::IMAGES_FOLDER . $reference;
            $image_people->save();
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
}
