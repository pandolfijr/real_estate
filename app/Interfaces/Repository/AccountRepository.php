<?php

namespace App\Interfaces\Repository;

use App\Helpers\Result;

interface AccountRepository
{
    public function getAccounts(array $data, bool $paginate = false): Result;
    public function saveAccount(array $input): Result;
    public function updateAccount(array $input, string $id_locator): Result;
    public function getAccountById(string $id): Result;
    public function deleteAccount(string $id_account): Result;
    public function restoreAccount(string $id_account): Result;
    public function getInstallments(array $data, bool $paginate = false): Result;
    public function getInstallmentById(string $id): Result;
    public function getInstallmentsByIdTransaction(string $id_transaction, $input = []): Result;
    public function updateInstallment(array $input, string $id_installment): Result;
}
