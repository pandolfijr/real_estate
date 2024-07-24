<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;

use App\Interfaces\Repository\TransactionRepository;
use App\Models\AccountPayReceive;
use App\Models\Casher;
use App\Models\Installment;
use Illuminate\Database\Eloquent\Relations\BelongsTo as QueryBuilder;

use App\Models\Transaction;

use Exception;


class TransactionRepositoryImpl implements TransactionRepository
{


    public function getTransactions(array $input, bool $paginate = false): Result
    {
        try {
            $db = Transaction::orderBy('id')->with(['property', 'locator.people', 'renter.people']);

            if (isset($input['search'])) {
                $db->where(function ($query) use ($input) {
                    $query->whereHas('property', function ($query) use ($input) {
                        $query->where('description', 'LIKE', '%' . $input['search'] . '%')
                            ->orWhere('reference', 'LIKE', '%' . $input['search'] . '%');
                    })
                        ->orWhereHas('locator.people', function ($query) use ($input) {
                            $query->where('name', 'LIKE', '%' . $input['search'] . '%')
                                ->orWhere('surname', 'LIKE', '%' . $input['search'] . '%');
                        })
                        ->orWhereHas('renter.people', function ($query) use ($input) {
                            $query->where('name', 'LIKE', '%' . $input['search'] . '%')
                                ->orWhere('surname', 'LIKE', '%' . $input['search'] . '%');
                        })
                        ->orWhere('observations', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('insurance_number', 'LIKE', '%' . $input['search'] . '%');
                });
            }

            if (isset($input['status']) && !empty($input['status'])) {
                if ($input['status'] == Transaction::INACTIVE) {  // inativos
                    $db->onlyTrashed();
                } elseif ($input['status'] == Transaction::ALL) { // todos
                    $db->withTrashed();
                }
            }

            if (isset($input['contract_status']) && !empty($input['contract_status'])) {
                $db->where('contract_status', $input['contract_status']);
            }

            // dd($db->toSql(), $db->getBindings());
            $transactions = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($transactions);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > getTransactions',
                    'Erro ao buscar transações: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function saveTransaction(array $input): Result
    {
        try {
            $transaction = Transaction::insertGetId($input);
            if (!$transaction) {
                return Result::error(
                    new ErrorApplication(
                        'TransactionRepositoryImpl > saveTransaction > create',
                        'Não foi possível criar o proprietário',
                        500,
                    )
                );
            }
            return Result::success($transaction);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > saveTransaction',
                    'Erro ao salvar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function saveInstallment(array $input): Result
    {
        try {

            $installment = Installment::create($input);
            if (!$installment) {
                return Result::error(
                    new ErrorApplication(
                        'TransactionRepositoryImpl > saveInstallment > create',
                        'Não foi possível criar o proprietário',
                        422,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > saveInstallment',
                    'Erro ao salvar parcela: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    public function updateTransaction(array $input, string $id_transaction): Result
    {
        try {
            $supplier = Transaction::where('id', $id_transaction)->withTrashed()->first();
            $supplier->fill($input);
            $supplier->update();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'TransactionRepositoryImpl > updateTransaction >  update',
                        'Não foi possível atualizar o proprietário',
                        400,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > updateTransaction',
                    'Erro ao atualizar proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param array $input
     * @param string $id_installment
     * @return Result
     */
    public function updateInstallment(array $input, string $id_installment): Result
    {
        try {
            $installment = Installment::where('id', $id_installment)->first();
            $installment->fill($input);
            $installment->update();
            if (!$installment) {
                return Result::error(
                    new ErrorApplication(
                        'TransactionRepositoryImpl > updateInstallment >  update',
                        'Erro ao atualizar a parcela',
                        400,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > updateInstallment',
                    'Erro ao atualizar a parcela: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param array $input
     * @param string $id_installment
     * @return Result
     */
    public function deleteInstallmentsByIdTransaction(string $id_transaction): Result
    {
        try {
            $installment = Installment::where('id_transact', $id_transaction)->delete();
            if (!$installment) {
                return Result::error(
                    new ErrorApplication(
                        'TransactionRepositoryImpl > updateInstallment >  update',
                        'Erro ao atualizar a parcela',
                        400,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > updateInstallment',
                    'Erro ao atualizar a parcela: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getTransactionById(string $id): Result
    {
        try {
            $transaction = Transaction::with(['locator', 'renter', 'guarantor', 'keys', 'broker', 'property', 'installments'])->where('id', $id)->withTrashed()->first();
            return Result::success($transaction);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > getTransactionById',
                    'Erro ao buscar locadore: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function deleteTransaction(string $id_transaction): Result
    {
        try {
            $supplier = Transaction::where('id', $id_transaction)->first();
            $supplier->delete();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'TransactionRepositoryImpl > deleteTransaction > supplier > delete',
                        'Não foi possível remover o proprietário',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > deleteTransaction',
                    'Erro ao excluir proprietário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function restoreTransaction(string $id_transaction): Result
    {
        try {
            $supplier = Transaction::where('id', $id_transaction)->onlyTrashed()->first();
            $supplier->restore();
            if (!$supplier) {
                return Result::error(
                    new ErrorApplication(
                        'TransactionRepositoryImpl > deleteTransaction > supplier > delete',
                        'Não foi possível remover o proprietário',
                        500,
                    )
                );
            }

            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > restoreTransaction',
                    'Erro ao restaurar transações: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function generateAccountReceive(array $input): Result
    {
        try {

            $accountPay = AccountPayReceive::create($input);
            if (!$accountPay) {
                return Result::error(
                    new ErrorApplication(
                        'TransactionRepositoryImpl > generateAccountPay > create',
                        'Não foi possível criar a conta',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > generateAccountPay',
                    'Erro ao criar conta: ' . $e->getMessage(),
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
    public function generateBankTransaction(array $input): Result
    {
        try {
            $transaction = Casher::insertGetId($input);
            if (!$transaction) {
                return Result::error(
                    new ErrorApplication(
                        'TransactionRepositoryImpl > generateBankTransaction > insertGetId',
                        'Não foi possível criar a transação bancária',
                        400,
                    )
                );
            }
            return Result::success($transaction);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > generateBankTransaction',
                    'Não foi possível criar a transação bancária: ' . $e->getMessage(),
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
    public function getLastBankTransaction($id_bank_account): Result
    {
        try {
            $transaction = Casher::where('id_bank_account', $id_bank_account)->orderBy('id', 'desc')->limit(1)->first();
            return Result::success($transaction);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'TransactionRepositoryImpl > getLastBankTransaction',
                    'Não foi possível buscar a última transação bancária: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
}
