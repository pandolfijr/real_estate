<?php

namespace App\Services;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\AccountRepository;
use App\Interfaces\Repository\BankAccountRepository;
use App\Interfaces\Repository\LocalizationRepository;
use App\Interfaces\Repository\SupplierRepository;
use App\Interfaces\Service\AccountService;
use App\Interfaces\Service\BankAccountService;
use App\Interfaces\Service\LocalizationService;
use App\Interfaces\Service\SupplierService;
use App\Models\AccountPayReceive;
use App\Models\Casher;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BankAccountServiceImpl implements BankAccountService
{
    private $bankAccountRepository;
    private $accountService;

    public function __construct(
        BankAccountRepository $bankAccountRepository,
        AccountService $accountService
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->accountService = $accountService;
    }

    public function getBankAccounts(array $input, bool $paginate = false): Result
    {
        return $this->bankAccountRepository->getBankAccounts($input, $paginate);
    }
    public function saveBankAccount(array $input): Result
    {
        try {
            return DB::transaction(function () use ($input) {
                $result = $this->bankAccountRepository->saveBankAccount($input);
                if (!$result->isSuccess()) {
                    return Result::error(
                        new ErrorApplication(
                            'BankAccountServiceImpl > saveBankAccount',
                            'Erro ao salvar conta bancária: ' . $result->getData(),
                            400,
                        )
                    );
                }
                $bank_account = $result->getData();
                $data_casher = [
                    'final_value' => 0,
                    'id_bank_account' => $bank_account['id'],
                    'action' => Casher::DEPOSIT

                ];
                $result_casher = $this->accountService->generateBankTransactions($data_casher);
                if (!$result_casher->isSuccess()) {
                    return Result::error(
                        new ErrorApplication(
                            'BankAccountServiceImpl > generateBankTransactions',
                            'Erro ao gerar registro no caixa: ' ,
                            400,
                        )
                    );
                }
                return Result::success();
            });
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'BankAccountServiceImpl > saveBankAccount',
                    'Erro ao salvar conta bancária: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateBankAccount(array $input, string $id_bank_account): Result
    {
        return $this->bankAccountRepository->updateBankAccount($input, $id_bank_account);
    }
    public function getBankAccountById(string $id): Result
    {
        return $this->bankAccountRepository->getBankAccountById($id);
    }
    public function deleteBankAccount(string $id_bank_account): Result
    {
        return $this->bankAccountRepository->deleteBankAccount($id_bank_account);
    }
    public function restoreBankAccount(string $id_bank_account): Result
    {
        return $this->bankAccountRepository->restoreBankAccount($id_bank_account);
    }

    public function getCasherAccounts(array $input): Result
    {
        return $this->bankAccountRepository->getCasherAccounts($input);
    }

    public function getCasherBankAccountById(string $id_bank_account, array $input): Result
    {
        return $this->bankAccountRepository->getCasherBankAccountById($id_bank_account, $input);
    }

    public function getCasherAccount(array $input, bool $paginate = false): Result
    {
        return $this->bankAccountRepository->getCasherAccount($input, $paginate);
    }
}
