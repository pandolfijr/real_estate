<?php

namespace App\Interfaces\Service;

use App\Helpers\Result;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

interface LocalizationService
{
    public function getCities(array $input): Result;
    public function saveCity(array $input): Result;
    public function updateCity(array $input, string $id_city): Result;
    public function deleteCity(string $id_city): Result;
    public function getStates(): Result;
    public function getCityById(string $id_city): Result;
}
