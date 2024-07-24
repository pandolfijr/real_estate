<?php

namespace App\Interfaces\Service;

use App\Helpers\Result;

interface SupplierService
{
    public function getSuppliers(array $data, bool $paginate): Result;
    public function saveSupplier(array $input): Result;
    public function updateSupplier(array $input, string $id_locator): Result;
    public function getSupplierById(string $id): Result;
    public function deleteSupplier(string $id_user): Result;
    public function restoreSupplier(string $id_user): Result;
}
