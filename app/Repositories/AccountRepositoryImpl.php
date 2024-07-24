<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\AccountRepository;
use App\Models\Installment;
use Illuminate\Database\Eloquent\Collection;

use App\Interfaces\Repository\LocalizationRepository;
use App\Models\City;
use App\Models\Account;
use App\Models\AccountPayReceive;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AccountRepositoryImpl implements AccountRepository
{


    public function getAccounts(array $input, bool $paginate = false): Result
    {
        try {
            $db = AccountPayReceive::with(['locator.people', 'property', 'supplier' => function (QueryBuilder $query) use ($input) {
                if (isset($input['search'])) {
                    $query->where('name', 'LIKE', '%' . $input['search'] . '%');
                }
            }])
                ->orderByDesc('expect_date');

            if (isset($input['search'])) {
                $db->where(function ($query) use ($input) {
                    $query->where('description', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('id_supplier', 'LIKE', '%' . $input['search'] . '%');
                });
            }

            if (isset($input['status']) && !empty($input['status'])) {
                $db->where('status', $input['status']);
            } else {
                $db->where('status', AccountPayReceive::PENDING);
            }

            if (isset($input['type']) && !empty($input['type'])) {
                $db->where('type', $input['type']);
            }

            if (isset($input['category']) && !empty($input['category'])) {
                $db->where('category', $input['category']);
            }

            if (isset($input['id_renter']) && !empty($input['id_renter'])) {
                $db->where('id_renter', $input['id_renter']);
            }

            if (isset($input['id_property']) && !empty($input['id_property'])) {
                $db->where('id_property', $input['id_property']);
            }

            if (isset($input['transfer']) && !empty($input['transfer'])) {
                $db->where('id_property', '!=', null);
            }

            if (isset($input['month']) && !empty($input['month'])) {
                $db->whereMonth('expect_date', $input['month']);
            }

            if (isset($input['year']) && !empty($input['year'])) {
                $db->whereYear('expect_date', $input['year']);
            }

            if (isset($input['id_casher']) && $input['id_casher']) {
                $db->where('id_casher', '!=', null);
            }

            if (isset($input['expect_date']) && !empty($input['expect_date'])) {
                $db->where('expect_date', $input['expect_date']);
            }

            // dd($db->toSql(), $db->getBindings());
            $accounts = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($accounts);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > getAccounts',
                    'Erro ao buscar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function saveAccount(array $input): Result
    {
        try {
            $supplier = AccountPayReceive::create($input);
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'AccountRepositoryImpl > saveAccount > create',
                        'Não foi possível criar o proprietário',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > saveAccount',
                    'Erro ao salvar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateAccount(array $input, string $id_supplier): Result
    {
        try {
            $supplier = AccountPayReceive::where('id', $id_supplier)->withTrashed()->first();
            $supplier->fill($input);
            $supplier->update();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'AccountRepositoryImpl > updateAccount >  update',
                        'Não foi possível atualizar o proprietário',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > updateAccount',
                    'Erro ao atualizar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getAccountById(string $id): Result
    {
        try {
            $supplier = AccountPayReceive::with(['locator.people', 'property', 'supplier', 'bank_account'])->where('id', $id)->withTrashed()->first();
            return Result::success($supplier);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > getAccountById',
                    'Erro ao buscar locadore: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function deleteAccount(string $id_supplier): Result
    {
        try {
            $supplier = AccountPayReceive::where('id', $id_supplier)->first();
            $supplier->delete();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'AccountRepositoryImpl > deleteAccount > supplier > delete',
                        'Não foi possível remover o proprietário',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > deleteAccount',
                    'Erro ao excluir proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function restoreAccount(string $id_supplier): Result
    {
        try {
            $supplier = AccountPayReceive::where('id', $id_supplier)->onlyTrashed()->first();
            $supplier->restore();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'AccountRepositoryImpl > deleteAccount > supplier > delete',
                        'Não foi possível remover o proprietário',
                        500,
                    )
                );
            }

            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > restoreAccount',
                    'Erro ao restaurar proprietários: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getInstallments(array $input, bool $paginate = false): Result
    {
        try {
            $db = Installment::with([
                'locator.people' => function ($query) use ($input) {
                    if (isset($input['search'])) {
                        $query->orWhere('name', 'LIKE', '%' . $input['search'] . '%');
                    }
                },
                'renter.people' => function ($query) use ($input) {
                    if (isset($input['search'])) {
                        $query->orWhere('name', 'LIKE', '%' . $input['search'] . '%');
                    }
                },
                'property' => function ($query) use ($input) {
                    if (isset($input['search'])) {
                        $query->orWhere('description', 'LIKE', '%' . $input['search'] . '%')
                            ->orWhere('reference', 'LIKE', '%' . $input['search'] . '%');
                    }
                },
            ])
                ->orderBy('due_date', 'asc');

            if (isset($input['status']) && !empty($input['status'])) {
                $db->where('status', $input['status']);
                if ($input['status'] == AccountPayReceive::LATE)
                    $db->where('date_received', null)->where('due_date', '<',  Carbon::now()->toDateString());
            }

            if (isset($input['month']) && !empty($input['month'])) {
                $db->whereMonth('due_date', $input['month']);
            }

            if (isset($input['year']) && !empty($input['year'])) {
                $db->whereYear('due_date', $input['year']);
            }

            // if(isset($input['transfer']) && $input['transfer']){
            //     $db->where('date_received', '!=', null);
            // }

            if (isset($input['status_transfer'])) {
                if (intval($input['status_transfer'] == Installment::INSTALLMENT_STATUS_TRANSFER_DONE)) { // feitos
                    $db->where('status_transfer', '!=', null);
                } elseif (intval($input['status_transfer'] != Installment::INSTALLMENT_STATUS_TRANSFER_DONE)) { //pendentes
                    $db->where('status_transfer', null);
                }
            }

            if (isset($input['due_date']) && !empty($input['due_date'])) {
                $db->where('due_date', $input['due_date']);
            }

            //dd($db->toSql(), $db->getBindings());
            $installments = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($installments);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > getInstallments',
                    'Erro ao buscar parcelas dos imóveis: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getInstallmentById(string $id): Result
    {
        try {
            $installment = Installment::with(['locator.people', 'renter.people', 'property.city', 'property.condo',  'bank_account', 'casher'])->where('id', $id)->first();
            return Result::success($installment);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > getInstallmentById',
                    'Erro ao buscar parcelas do imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getInstallmentsByIdTransaction(string $id_transaction, $input = []): Result
    {
        try {
            $db = Installment::where('id_transact', $id_transaction);
            if (!empty($input))
                $db->where($input);

            $installments = $db->get();
            return Result::success($installments);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > getInstallmentById',
                    'Erro ao buscar parcelas do imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function updateInstallment(array $input, string $id_installment): Result
    {
        try {
            $supplier = Installment::where('id', $id_installment)->first();
            $supplier->fill($input);
            $supplier->update();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'AccountRepositoryImpl > updateInstallment >  update',
                        'Não foi possível atualizar a parcela',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountRepositoryImpl > updateInstallment',
                    'Erro ao atualizar parcela: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
}
