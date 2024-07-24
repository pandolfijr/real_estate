<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use Illuminate\Database\Eloquent\Collection;

use App\Interfaces\Repository\LocalizationRepository;
use App\Models\City;
use App\Models\State;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class LocalizationRepositoryImpl implements LocalizationRepository
{
    /**
     *
     * @param array $input
     * @return Result
     */
    public function getCities(array $input): Result
    {
        try {
            $db = City::with('state')->orderBy('name', 'asc');
            if (isset($input['search']))
                $db->where('name', 'LIKE', '%' . $input['search'] . '%');

            $cities = isset($input['paginate'])
                ? $db->paginate(30)
                : $db->get();
            return Result::success($cities);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'LocalizationRepository > queryLocalization',
                    'Erro ao buscar cidades',
                    500,
                )
            );
        }
    }


    /**
     *
     * @param array $input
     * @return Result
     */
    public function saveCity(array $input): Result
    {
        try {
            $city = new City();
            $city->fill($input);
            $city->save();
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'LocalizationRepository > saveCity',
                    'Erro ao salvar cidade: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param array $input
     * @param string $id_city
     * @return Result
     */
    public function updateCity(array $input, string $id_city): Result
    {
        try {
            $city = City::where('id', $id_city)->first();
            $city->fill($input);
            $city->update();
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'LocalizationRepository > updateCity',
                    'Erro ao atuaalizar cidade: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param string $id_city
     * @return Result
     */
    public function deleteCity(string $id_city): Result
    {
        try {
            $city = City::where('id', $id_city)->first();
            $city->delete();
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'LocalizationRepository > deleteCity',
                    'Erro ao remover cidade: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }


    /**
     *
     * @return Result
     */
    public function getStates(): Result
    {
        try {
            $states = State::get();
            if (!$states)
                return Result::error(
                    new ErrorApplication(
                        'LocalizationRepository > queryLocalization',
                        'Erro ao buscar estados',
                        400,
                    )
                );
            return Result::success($states);
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'LocalizationRepository > queryLocalization',
                    'Erro ao buscar cidades',
                    500,
                )
            );
        }
    }

    public function getCityById(string $id_city): Result
    {
        try {
            $city = City::where('id', $id_city)->first();
            return Result::success($city);
        } catch (Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'LocalizationRepository > getCityById',
                    'Erro ao buscar cidade: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
}
