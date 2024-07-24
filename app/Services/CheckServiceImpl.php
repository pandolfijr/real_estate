<?php

namespace App\Services;

use App\Helpers\Result;
use App\Interfaces\Repository\CheckRepository;
use App\Interfaces\Repository\LocalizationRepository;
use App\Interfaces\Repository\SupplierRepository;
use App\Interfaces\Service\CheckService;
use App\Interfaces\Service\LocalizationService;
use App\Interfaces\Service\SupplierService;
use App\Models\CheckPayReceive;
use Illuminate\Database\Eloquent\Collection;

class CheckServiceImpl implements CheckService
{
    private $checkRepository;

    public function __construct(CheckRepository $checkRepository)
    {
        $this->checkRepository = $checkRepository;
    }

    public function getChecks(array $input, bool $paginate = false): Result
    {
    return $this->checkRepository->getChecks($input, $paginate);
    }
    public function saveCheck(array $input): Result
    {
        return $this->checkRepository->saveCheck($input);
    }
    public function updateCheck(array $input, string $id_supplier): Result
    {
        return $this->checkRepository->updateCheck($input, $id_supplier);
    }
    public function getCheckById(string $id): Result
    {
        return $this->checkRepository->getCheckById($id);
    }
    public function deleteCheck(string $id_supplier): Result
    {
        return $this->checkRepository->deleteCheck($id_supplier);
    }
    public function restoreCheck(string $id_supplier): Result
    {
        return $this->checkRepository->restoreCheck($id_supplier);
    }
}
