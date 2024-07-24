<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\CheckRepository;
use Illuminate\Database\Eloquent\Collection;

use App\Interfaces\Repository\LocalizationRepository;
use App\Models\City;
use App\Models\Check;

use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CheckRepositoryImpl implements CheckRepository
{


    public function getChecks(array $input, bool $paginate = false): Result
    {
        try {
            $db = Check::orderBy('id');
            
            if (isset($input['search'])) {
                $db->where(function ($query) use ($input) {
                    $query->where('description', 'LIKE', '%' . $input['search'] . '%')
                          ->orWhere('number', 'LIKE', '%' . $input['search'] . '%')
                          ->orWhere('favored_name', 'LIKE', '%' . $input['search'] . '%')
                          ->orWhere('description', 'LIKE', '%' . $input['search'] . '%')
                          ->orWhere('status', 'LIKE', '%' . $input['search'] . '%');
                });
            }

            if (isset($input['type']) && !empty($input['type'])) {
                $db->where('type', $input['type']);
            }

            $checks = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($checks);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'CheckRepositoryImpl > getChecks',
                    'Erro ao buscar chequees: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function saveCheck(array $input): Result
    {
        try {
            $check = Check::create($input);
            if (!$check) {
                return Result::error(
                    new ErrorApplication(
                        'CheckRepositoryImpl > saveCheck > create',
                        'Não foi possível criar o cheque',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'CheckRepositoryImpl > saveCheck',
                    'Erro ao salvar cheque: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateCheck(array $input, string $id_check): Result
    {
        try {
            $check = Check::where('id', $id_check)->first();
            $check->fill($input);
            $check->update();
            if (!$check) {
                return Result::error(
                    new ErrorApplication(
                        'CheckRepositoryImpl > updateCheck >  update',
                        'Não foi possível atualizar o cheque',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'CheckRepositoryImpl > updateCheck',
                    'Erro ao atualizar cheque: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getCheckById(string $id): Result
    {
        try {
            $check = Check::where('id', $id)->first();
            return Result::success($check);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'CheckRepositoryImpl > getCheckById',
                    'Erro ao buscar chequee: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function deleteCheck(string $id_check): Result
    {
        try {
            $check = Check::where('id', $id_check)->first();
            $check->delete();
            if (!$check) {
                return Result::error(
                    new ErrorApplication(
                        'CheckRepositoryImpl > deleteCheck > check > delete',
                        'Não foi possível remover o cheque',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'CheckRepositoryImpl > deleteCheck',
                    'Erro ao excluir cheque: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function restoreCheck(string $id_check): Result
    {
        try {
            $check = Check::where('id', $id_check)->onlyTrashed()->first();
            $check->restore();
            if (!$check) {
                return Result::error(
                    new ErrorApplication(
                        'CheckRepositoryImpl > deleteCheck > check > delete',
                        'Não foi possível remover o cheque',
                        500,
                    )
                );
            }

            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'CheckRepositoryImpl > restoreCheck',
                    'Erro ao restaurar chequees: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
}
