<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\BankAccountRepository;
use App\Interfaces\Repository\BankBankAccountRepository;
use Illuminate\Database\Eloquent\Collection;

use App\Interfaces\Repository\LocalizationRepository;
use App\Models\City;
use App\Models\BankAccount;
use App\Models\Casher;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo as QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BankAccountRepositoryImpl implements BankAccountRepository
{


    public function getCasherAccount(array $input, bool $paginate = false): Result
    {
        try {
            $db = Casher::with('bank_account')->select('casher.*')
                ->join(
                    DB::raw('(SELECT id_bank_account, MAX(date_current_action) AS max_date
                            FROM casher
                            GROUP BY id_bank_account) AS max_dates'),
                    function ($join) {
                        $join->on('casher.id_bank_account', '=', 'max_dates.id_bank_account')
                            ->on('casher.date_current_action', '=', 'max_dates.max_date');
                    }
                )
                ->join(
                    DB::raw('(SELECT id_bank_account, MAX(id) AS max_id
                            FROM casher
                            GROUP BY id_bank_account) AS max_ids'),
                    function ($join) {
                        $join->on('casher.id_bank_account', '=', 'max_ids.id_bank_account')
                            ->on('casher.id', '=', 'max_ids.max_id');
                    }
                );
            $bank_accounts = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($bank_accounts);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountRepositoryImpl > getBankAccounts',
                    'Erro ao buscar conta bancáriaes: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getBankAccounts(array $input, bool $paginate = false): Result
    {
        try {
            $db = BankAccount::orderBy('id');

            if (isset($input['search'])) {
                $db->where(function ($query) use ($input) {
                    $query->where('description', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('bank_code', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('bank_name', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('agency', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('account', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('account_name', 'LIKE', '%' . $input['search'] . '%');
                });
            }

            if (isset($input['status']) && !empty($input['status'])) {
                if ($input['status'] == BankAccount::INACTIVE)  // inativos
                    $db->onlyTrashed();
                elseif ($input['status'] == BankAccount::ALL) // todos
                    $db->withTrashed();
            }

            $bank_accounts = $paginate ? $db->paginate(30) : $db->get();
            return Result::success($bank_accounts);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountRepositoryImpl > getBankAccounts',
                    'Erro ao buscar conta bancáriaes: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function saveBankAccount(array $input): Result
    {
        try {
            $bank_account = BankAccount::create($input);
            if (!$bank_account) {
                return Result::error(
                    new ErrorApplication(
                        'BankAccountRepositoryImpl > saveBankAccount > create',
                        'Não foi possível criar a conta bancária',
                        500,
                    )
                );
            }
            return Result::success($bank_account);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountRepositoryImpl > saveBankAccount',
                    'Erro ao salvar conta bancária: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateBankAccount(array $input, string $id_supplier): Result
    {
        try {
            $bank_account = BankAccount::where('id', $id_supplier)->withTrashed()->first();
            $bank_account->fill($input);
            $bank_account->update();
            if (!$bank_account) {
                return Result::error(
                    new ErrorApplication(
                        'BankAccountRepositoryImpl > updateBankAccount >  update',
                        'Não foi possível atualizar a conta bancária',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountRepositoryImpl > updateBankAccount',
                    'Erro ao atualizar conta bancária: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getBankAccountById(string $id): Result
    {
        try {
            $bank_account = BankAccount::where('id', $id)->withTrashed()->first();
            return Result::success($bank_account);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountRepositoryImpl > getBankAccountById',
                    'Erro ao buscar conta bancáriae: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function deleteBankAccount(string $id_supplier): Result
    {
        try {
            $bank_account = BankAccount::where('id', $id_supplier)->first();
            $bank_account->delete();
            if (!$bank_account) {
                return Result::error(
                    new ErrorApplication(
                        'BankAccountRepositoryImpl > deleteBankAccount > supplier > delete',
                        'Não foi possível remover a conta bancária',
                        500,
                    )
                );
            }
            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountRepositoryImpl > deleteBankAccount',
                    'Erro ao excluir conta bancária: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function restoreBankAccount(string $id_supplier): Result
    {
        try {
            $bank_account = BankAccount::where('id', $id_supplier)->onlyTrashed()->first();
            $bank_account->restore();
            if (!$bank_account) {
                return Result::error(
                    new ErrorApplication(
                        'BankAccountRepositoryImpl > deleteBankAccount > supplier > delete',
                        'Não foi possível remover a conta bancária',
                        500,
                    )
                );
            }

            return Result::success();
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountRepositoryImpl > restoreBankAccount',
                    'Erro ao restaurar conta bancáriaes: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getCasherAccounts(array $input, bool $paginate = false): Result
    {
        try {

            $latestTransactions = Casher::with(['account'])->select('casher.id_bank_account', DB::raw('MAX(casher.id) as latest_id'))
                ->groupBy('casher.id_bank_account');

            $db = Casher::with(['bank_account','transaction'])
                ->joinSub($latestTransactions, 'latest', function ($join) {
                    $join->on('casher.id', '=', 'latest.latest_id');
                })
                ->orderBy('casher.id');

            $bank_accounts = $db->get();
            return Result::success($bank_accounts);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountRepositoryImpl > getgetCasherAccountsBankAccounts',
                    'Erro ao buscar dados bancários no caixa: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getCasherBankAccountById(string $id_bank_account, array  $input): Result
    {
        try {
            $db =  Casher::with(['bank_account', 'account'])
                ->where('id_bank_account', $id_bank_account)
                ->orderBy('id', 'asc');

            if ($input['initial_date'])
                $db->where('date_current_action', '>=', $input['initial_date']);

            if ($input['end_date'])
                $db->where('date_current_action', '<=', $input['end_date']);

            if ($input['action']) {
                $db->where('casher.action', $input['action']);
            }

            $bank_account = $db->get();
            return Result::success($bank_account);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountRepositoryImpl > getCasherBankAccountById',
                    'Erro ao buscar dados bancários no fluxo de caixa: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
}
