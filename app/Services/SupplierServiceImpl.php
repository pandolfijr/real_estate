<?php

namespace App\Services;

use App\Helpers\Result;
use App\Interfaces\Repository\LocalizationRepository;
use App\Interfaces\Repository\SupplierRepository;
use App\Interfaces\Service\LocalizationService;
use App\Interfaces\Service\SupplierService;
use Illuminate\Database\Eloquent\Collection;

class SupplierServiceImpl implements SupplierService
{
    private $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getSuppliers(array $data, bool $paginate): Result
    {
        return $this->supplierRepository->getSuppliers($data, $paginate);
    }
    public function saveSupplier(array $input): Result
    {
        return $this->supplierRepository->saveSupplier($input);
    }
    public function updateSupplier(array $input, string $id_renter): Result
    {
        return $this->supplierRepository->updateSupplier($input, $id_renter);
    }
    public function getSupplierById(string $id): Result
    {
        return $this->supplierRepository->getSupplierById($id);
    }
    public function deleteSupplier(string $id_renter): Result
    {
        return $this->supplierRepository->deleteSupplier($id_renter);
    }
    public function restoreSupplier(string $id_renter): Result
    {
        return $this->supplierRepository->restoreSupplier($id_renter);
    }
}
