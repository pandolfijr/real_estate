<?php

namespace App\Interfaces\Repository;

use App\Helpers\Result;

interface BankAccountRepository
{
    public function getBankAccounts(array $data, bool $paginate = false): Result;
    public function saveBankAccount(array $input): Result;
    public function updateBankAccount(array $input, string $id_bank_account): Result;
    public function getBankAccountById(string $id): Result;
    public function deleteBankAccount(string $id_bank_account): Result;
    public function restoreBankAccount(string $id_bank_account): Result;
    public function getCasherAccounts(array $data): Result;
    public function getCasherBankAccountById(string $id_bank_account, array $data): Result;
    public function getCasherAccount(array $data, bool $paginate = false): Result;
}
