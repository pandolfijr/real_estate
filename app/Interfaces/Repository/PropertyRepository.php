<?php

namespace App\Interfaces\Repository;

use App\Helpers\Result;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;

interface PropertyRepository
{
    public function getProperties(array $input, bool $paginate = false): Result;
    public function getTotalProperties(): Result;
    public function saveProperty(array $input): Result;
    public function updateProperty(array $input, string $id_property): Result;
    public function getPropertyById(string $id): Result;
    public function getPropertyByReference(string $reference): ?Property;
    public function pictureExists(string $id): ?bool;
    public function deleteProperty(string $id_city): Result;
    public function restoreProperty(string $id_property): Result;
    public function setFalseImageProperty(array $input, string $id_property): Result;
    public function setTrueImageProperty(array $input, string $id_property): Result;
    public function saveImage(string $id_property, string $reference, string $filename, int $counter, bool $exists, ?bool $main = false): Result;
    public function getCondos(array $input, bool $paginate = false): Result;
    public function saveCondo(array $input): Result;
    public function updateCondo(array $input, string $id_condo): Result;
    public function deleteCondo(string $id_condo): Result;
    public function restoreCondo(string $id_condo): Result;
    public function getCondoById(string $id): Result;
    public function deletePictures(array $pictures_id, string $id_property): Result;
    public function updateMainPicture(string $id_picture, string $id_property): Result;
    public function propertyExists(string $id_city): bool;
    public function getPropertiesByIdLocator(string $id): Result;

}
