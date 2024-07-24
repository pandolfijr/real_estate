<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\LocalizationService;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Exception;

class CityController extends Controller
{
    private $localizationService;
    public function __construct(LocalizationService $localizationService)
    {
        $this->localizationService = $localizationService;
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $input = $request->all();
            $result = $this->localizationService->getCities($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $cities = $result->getData();
            return response()->json(['cities' => $cities], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|min:3|max:25',
            'id_state' => 'required',
        ]);

        $input = $request->all();
        try {
            $result = $this->localizationService->saveCity($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Cidade salva com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


        /**
     * Display the specified resource.
     */
    public function show($id_city)
    {
        try {
            $result = $this->localizationService->getCityById($id_city);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $city = $result->getData();
            return response()->json(['city' => $city], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param Request $request
     * @param string $id_city
     * @return void
     */
    public function update(Request $request, string $id_city)
    {
        $request->validate([
            'name' => 'required|min:3|max:25',
            'id_state' => 'required',
        ]);

        $input = $request->all();
        try {
            $result = $this->localizationService->updateCity($input, $id_city);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Cidade alterada com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_city
     * @return JsonResponse
     */
    public function destroy(string $id_city): JsonResponse
    {
        try {
            $result = $this->localizationService->deleteCity($id_city);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Cidade removida com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getStates(): JsonResponse
    {
        try {
            $result = $this->localizationService->getStates();
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $states = $result->getData();
            return response()->json(['states' => $states], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
