<?php

namespace App\Services;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\AccountRepository;
use App\Interfaces\Repository\LocalizationRepository;
use App\Interfaces\Repository\SupplierRepository;
use App\Interfaces\Repository\TransactionRepository;
use App\Interfaces\Service\AccountService;
use App\Interfaces\Service\LocalizationService;
use App\Interfaces\Service\SupplierService;
use App\Models\AccountPayReceive;
use App\Models\Casher;
use App\Models\Installment;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AccountServiceImpl implements AccountService
{
    private $accountRepository;
    private $transactionRepository;

    public function __construct(
        AccountRepository $accountRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function getAccounts(array $input, bool $paginate = false): Result
    {
        return $this->accountRepository->getAccounts($input, $paginate);
    }
    public function saveAccount(array $input): Result
    {
        return $this->accountRepository->saveAccount($input);
    }
    public function updateAccount(array $input, string $id_account): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_account) {
                $account = $this->accountRepository->updateAccount($input, $id_account);
                if (!$account->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'AccountServiceImpl > updateAccount',
                            'Erro ao atualizar conta:',
                            400,
                        )
                    );

                $input['id_account_pay_receive'] = $id_account;
                if ($input['status'] == AccountPayReceive::PAIDOUT) { //gerar caixa
                    $result_transaction = $this->generateBankTransactions($input);
                    if (!$result_transaction->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'AccountServiceImpl > generateBankTransactions',
                                'Erro ao gerar registro bancário: ',
                                400,
                            )
                        );
                    $id_casher = $result_transaction->getData();
                    $result_casher = $this->accountRepository->updateAccount(['id_casher' => $id_casher], $id_account);
                    if (!$result_casher->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'AccountServiceImpl > updateAccount',
                                'Erro ao atualizar id do registro bancário na conta: ',
                                400,
                            )
                        );
                }

                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountServiceImpl > updateAccount',
                    'Erro ao atualizar conta: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getAccountById(string $id): Result
    {
        return $this->accountRepository->getAccountById($id);
    }
    public function deleteAccount(string $id_account): Result
    {
        return $this->accountRepository->deleteAccount($id_account);
    }
    public function restoreAccount(string $id_account): Result
    {
        return $this->accountRepository->restoreAccount($id_account);
    }

    public function generateBankTransactions(array $input): Result
    {
        try {
            $result = $this->transactionRepository->getLastBankTransaction($input['id_bank_account']);
            if (!$result->isSuccess())
                return Result::error(
                    new ErrorApplication(
                        'AccountService > generateBankTransactions > getLastBankTransaction',
                        $result->getError()->getMessage(),
                        $result->getError()->getCode(),
                    )
                );

            $previous_transaction = $result->getData();

            if ($previous_transaction) {
                $previous_value = $previous_transaction->current_value;
                $date_last_action = $previous_transaction->date_last_action;

                if ($input['action'] == Casher::DEPOSIT) {
                    $current_value = floatval($previous_value) + (isset($input['id_installment']) ?  floatval($input['installment_total_value']) : floatval($input['final_value']));
                } elseif ($input['action'] == Casher::OUTFLOW) {
                    $current_value = floatval($previous_value) - (isset($input['id_installment']) ?  floatval($input['installment_total_value']) : floatval($input['final_value']));
                }
            } else {
                $previous_value = 0;
                $date_last_action = Carbon::now()->toDateString();
                $current_value = (isset($input['id_installment']) ?  $input['installment_total_value'] : $input['final_value']) ?? 0;
            }
            $round_current_value = round($current_value, 2);
            $data = [
                'action' => $input['action'],
                'previous_value' => $previous_value,
                'current_value' => $round_current_value,
                'account_value' => isset($input['id_installment']) ?  $input['installment_total_value'] : $input['final_value'],
                'date_last_action' => $date_last_action,
                'date_current_action' => Carbon::now()->toDateTimeString(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'id_bank_account' => $input['id_bank_account'],
            ];

            if (isset($input['id_installment']) && !empty($input['id_installment']))
                $data['id_installment'] = $input['id_installment'];

            if (isset($input['id_check']) && !empty($input['id_check']))
                $data['id_check'] = $input['id_check'];

            if (isset($input['id_account_pay_receive'])  && !empty($input['id_account_pay_receive']))
                $data['id_account_pay_receive'] = $input['id_account_pay_receive'];

            if (isset($input['id_installment_transfer']) && !empty($input['id_installment_transfer']))
                $data['id_installment_transfer'] = $input['id_installment_transfer'];

            $result_casher = $this->transactionRepository->generateBankTransaction($data);
            if (!$result_casher->isSuccess())
                return Result::error(
                    new ErrorApplication(
                        'AccountService > generateBankTransactions > getLastBankTransaction',
                        $result->getError()->getMessage(),
                        $result->getError()->getCode(),
                    )
                );
            $id_casher = $result_casher->getData();
            return Result::success($id_casher);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountServiceImpl > updateAccount',
                    'Erro ao atualizar conta: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getInstallments(array $input, bool $paginate = false): Result
    {
        return $this->accountRepository->getInstallments($input, $paginate);
    }

    public function getInstallmentById(string $id): Result
    {
        return $this->accountRepository->getInstallmentById($id);
    }

    public function updateInstallment(array $input, string $id_installment): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_installment) {
                $input['date_received'] = Carbon::now()->toDateString();
                $account = $this->accountRepository->updateInstallment($input, $id_installment);
                if (!$account->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'AccountServiceImpl > updateInstallment',
                            'Erro ao atualizar parcela:',
                            400,
                        )
                    );

                $input['id_installment'] = $id_installment;
                if ($input['status'] == Installment::INSTALLMENT_RECEIVED) { //gerar caixa
                    $result_transaction = $this->generateBankTransactions($input);
                    if (!$result_transaction->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'AccountServiceImpl > generateBankTransactions',
                                'Erro ao gerar registro bancário: ',
                                400,
                            )
                        );
                    $id_casher = $result_transaction->getData();
                    $result_casher = $this->accountRepository->updateInstallment(['id_casher' => $id_casher], $id_installment);
                    if (!$result_casher->isSuccess())
                        return Result::error(
                            new ErrorApplication(
                                'AccountServiceImpl > updateInstallment',
                                'Erro ao atualizar id do registro bancário na conta: ',
                                400,
                            )
                        );
                }

                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountServiceImpl > updateInstallment',
                    'Erro ao atualizar parcela : ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function sendTransfer(array $input, string $id_installment): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_installment) {

                $data = [
                    'transfer_value' => $input['transfer_value'],
                    'status_transfer' => Installment::INSTALLMENT_STATUS_TRANSFER_DONE,
                    'id_bank_account_transfer' => $input['id_bank_account_transfer'],
                    'date_received' => Carbon::now()->toDateString()
                ];
                $result = $this->transactionRepository->updateInstallment($data, $id_installment);
                if (!$result->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'AccountServiceImpl > updateInstallment',
                            'Erro ao atualizar parcela',
                            400,
                        )
                    );
                $data_transact = [
                    'action' => Casher::OUTFLOW,
                    'installment_total_value' => $input['transfer_value'],
                    'id_installment' => $id_installment,
                    'id_installment_transfer' => $id_installment,
                    'id_transaction' => $input['id_transact'],
                    'id_bank_account' =>  $input['id_bank_account_transfer'],
                ];
                $result_bank_transaction = $this->generateBankTransactions($data_transact);
                if (!$result_bank_transaction->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'AccountServiceImpl > generateBankTransactions',
                            'Erro ao gerar registro bancário: ',
                            400,
                        )
                    );
                $id_casher = $result_bank_transaction->getData();
                $result_casher = $this->accountRepository->updateInstallment(['id_casher_transfer' => $id_casher], $id_installment);
                if (!$result_casher->isSuccess())
                    return Result::error(
                        new ErrorApplication(
                            'AccountServiceImpl > updateAccount',
                            'Erro ao atualizar id do registro bancário na conta: ',
                            400,
                        )
                    );
                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'AccountServiceImpl > sendTransfer',
                    'Erro ao atualizar a parcela: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
}
