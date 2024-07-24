<?php

namespace App\Interfaces\Repository;

use App\Helpers\Result;
use Illuminate\Database\Eloquent\Collection;
interface PeopleRepository
{
    public function getLocators(array $data, bool $paginate): Result;
    public function getTotalLocators(): Result;
    public function saveLocator(array $input): Result;
    public function updateLocator(array $input, string $id_locator): Result;
    public function getLocatorById(string $id): Result;
    public function deleteLocator(string $id_user): Result;
    public function restoreLocator(string $id_user): Result;

    public function getRenters(array $data, bool $paginate): Result;
    public function getTotalRenters(): Result;
    public function saveRenter(array $input): Result;
    public function updateRenter(array $input, string $id_user): Result;
    public function getRenterById(string $id): Result;
    public function deleteRenter(string $id_user): Result;
    public function restoreRenter(string $id_user): Result;


    public function getGuarantors(array $data, bool $paginate): Result;
    public function saveGuarantor(array $input): Result;
    public function updateGuarantor(array $input, string $id_user): Result;
    public function getGuarantorById(string $id): Result;
    public function deleteGuarantor(string $id_user): Result;
    public function restoreGuarantor(string $id_user): Result;

    public function imageExists(string $id): ?bool;
    public function saveImage(string $id_property, string $reference, string $filename, string $type): Result;
    public function getPeopleByCpf(string $cpf): Result;
    public function savePeople(array $input): Result;
    public function getLocatorByIdPeople(string $cpf): Result;
    public function getGuarantorByIdPeople(string $cpf): Result;
    public function getRenterByIdPeople(string $cpf): Result;
}



