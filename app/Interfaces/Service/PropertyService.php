<?php

namespace App\Interfaces\Service;

use App\Helpers\Result;
use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PropertyService
{
    public function getProperties(array $input, bool $paginate = false): Result;
    public function getTotalProperties(): Result;
    public function saveProperty(array $input): Result;
    public function updateProperty(array $input, string $id_property): Result;
    public function deleteProperty(string $id_property): Result;
    public function restoreProperty(string $id_property): Result;
    public function generateReference(string $tipo): string;
    public function updateImageProperty(array $input, string $id_property): Result;
    public function getPropertyById(string $id): Result;
    public function getPropertiesByIdLocator(string $id): Result;

    public function getCondos(array $input, bool $paginate = false): Result;
    public function saveCondo(array $input): Result;
    public function updateCondo(array $input, string $id_condo): Result;
    public function deleteCondo(string $id_condo): Result;
    public function restoreCondo(string $id_condo): Result;
    public function getCondoById(string $id): Result;
    public function propertyExists(string $id_city): bool;

}
