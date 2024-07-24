<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\PropertyService;
use App\Models\Condo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CondoController extends Controller
{
    private $propertyService;
    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $input = $request->all();
            $result = $this->propertyService->getCondos($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $condos = $result->getData();
            return response()->json(['condos' => $condos], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // var_dump($request->all());exit;
        $customAttributes = [
            'description' => 'descrição',
            'type' => 'tipo',
            'address' => 'endereço',
            'number' => 'número',
            'district' => 'bairro',
            'cep' => 'cep',
            'id_city' => 'cidade'
        ];
        $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|max:5',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:5',
            'district' => 'required|string|max:30',
            'cep' => 'required|string|max:8',
            'id_city' => 'required',
        ], [], $customAttributes);

        $input = $request->all();
        // var_dump($input);exit;

        try {
            $result = $this->propertyService->saveCondo($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Condomínio salvo com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_supplier)
    {
        try {
            $result = $this->propertyService->getCondoById($id_supplier);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $condo = $result->getData();
            return response()->json(['condo' => $condo], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_supplier)
    {
        $input = $request->all();

        $customAttributes = [
            'description' => 'descrição',
            'type' => 'tipo',
            'address' => 'endereço',
            'number' => 'número',
            'district' => 'bairro',
            'cep' => 'cep',
            'id_city' => 'cidade'
        ];
        $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|max:5',
            'address' => 'required|string|max:255',
            'number' => 'required|string|max:5',
            'district' => 'required|string|max:30',
            'cep' => 'required|string|max:8',
            'id_city' => 'required',
        ], [], $customAttributes);

        try {
            $result = $this->propertyService->updateCondo($input, $id_supplier);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Condomínio atualizado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_supplier)
    {
        try {
            $result = $this->propertyService->deleteCondo($id_supplier);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Condomínio removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_supplier
     * @return JsonResponse
     */
    public function restore(string $id_supplier): JsonResponse
    {
        try {
            $result = $this->propertyService->restoreCondo($id_supplier);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Condomínio restaurado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
