<?php

namespace App\Services;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\LocalizationRepository;
use App\Interfaces\Service\LocalizationService;
use App\Interfaces\Service\PropertyService;
use Illuminate\Database\Eloquent\Collection;

class LocalizationServiceImpl implements LocalizationService
{
    private $localizationRepository;
    private $propertyService;

    public function __construct(
        LocalizationRepository $localizationRepository,
        PropertyService $propertyService)
    {
        $this->localizationRepository = $localizationRepository;
        $this->propertyService = $propertyService;
    }

    public function getCities(array $input): Result
    {
        return $this->localizationRepository->getCities($input);
    }

    public function saveCity(array $input): Result
    {
        return $this->localizationRepository->saveCity($input);
    }

    public function updateCity(array $input, string $id_city): Result
    {
        return $this->localizationRepository->updateCity($input, $id_city);
    }

    public function deleteCity(string $id_city): Result
    {
        $properties = $this->propertyService->propertyExists($id_city);
        if($properties){
            return Result::error(
                new ErrorApplication(
                    'LocalizationService > deleteCity',
                    'Não é possível remover a cidade. Existem imóveis associados.',
                    422,
                )
            );
        }
        return $this->localizationRepository->deleteCity($id_city);
    }

    public function getStates(): Result
    {
        return $this->localizationRepository->getStates();
    }

    public function getCityById(string $id_city): Result
    {
        return $this->localizationRepository->getCityById($id_city);
    }


}
