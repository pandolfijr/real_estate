<?php

namespace App\Interfaces\Repository;

use App\Helpers\Result;

interface TransactionRepository
{
    public function getTransactions(array $data, bool $paginate = false): Result;
    public function saveTransaction(array $input): Result;
    public function updateTransaction(array $input, string $id_locator): Result;
    public function getTransactionById(string $id): Result;
    public function deleteTransaction(string $id_transaction): Result;
    public function restoreTransaction(string $id_transaction): Result;
    public function saveInstallment(array $input): Result;
    public function generateAccountReceive (array $input): Result;
    public function getLastBankTransaction($id_bank_account): Result;
    public function generateBankTransaction(array $input): Result;
    public function updateInstallment(array $input, string $id_installment): Result;
    public function deleteInstallmentsByIdTransaction(string $id_transaction): Result;
}
