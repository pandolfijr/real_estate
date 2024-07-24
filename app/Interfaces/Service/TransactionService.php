<?php

namespace App\Interfaces\Service;

use App\Helpers\Result;

interface TransactionService
{
    public function getTransactions(array $data, bool $paginate = false): Result;
    public function saveTransaction(array $input): Result;
    public function updateTransaction(array $input, string $id_locator): Result;
    public function getTransactionById(string $id): Result;
    public function deleteTransaction(string $id_transaction): Result;
    public function restoreTransaction(string $id_transaction): Result;
    public function cancelTransaction(array $input, string $id_installment): Result;
}
