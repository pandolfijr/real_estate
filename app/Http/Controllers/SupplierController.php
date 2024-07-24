<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\SupplierService;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $supplierService;
    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $input = $request->all();
            $result = $this->supplierService->getSuppliers($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $suppliers = $result->getData();
            return response()->json(['suppliers' => $suppliers], 200);
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
            'name' => 'nome',
            'cellphone' => 'celular',
            'telephone' => 'celular',
            'address' => 'endereço',
            'id_city' => 'cidade',
            'type_person' => 'tipo de fornecedor',
            'category' => 'categoria'
        ];
        $request->validate([
            'name' => 'required|string|max:100',
            'telephone' => 'unique:suppliers|string|max:11',
            'cellphone' => 'unique:suppliers|string|max:11',

            'cpf' => 'nullable|string|max:11|unique:suppliers',
            'cnpj' => 'nullable|string|max:14|unique:suppliers',

            'email' => 'nullable|unique:suppliers|string|email|max:140',
            'id_city' => 'required|numeric',
            'type_person' => 'required|numeric',
            'category' => 'required|numeric',
        ], [], $customAttributes);

        $input = $request->all();

        try {
            $result = $this->supplierService->saveSupplier($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Fornecedor salvo com sucesso!'], 200);
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
            $result = $this->supplierService->getSupplierById($id_supplier);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $supplier = $result->getData();
            return response()->json(['supplier' => $supplier], 200);
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
            'name' => 'nome',
            'cellphone' => 'celular',
            'telephone' => 'celular',
            'address' => 'endereço',
            'id_city' => 'cidade',
            'type_person' => 'tipo de fornecedor',
            'category' => 'categoria'
        ];
        $request->validate([
            'name' => 'required|string|max:100',
            'cpf' => 'nullable|string|max:11|unique:suppliers,cpf,' .  $id_supplier,
            'cnpj' => 'nullable|string|max:14|unique:suppliers,cnpj,' .  $id_supplier,
            'telephone' => 'nullable|string|max:11|unique:suppliers,telephone,' .  $id_supplier,
            'cellphone' => 'nullable|string|max:11|unique:suppliers,cellphone,' .  $id_supplier,
            'email' => 'nullable|string|email|max:140|unique:suppliers,email,' .  $id_supplier,
            'address' => 'required|string|max:255',
            'id_city' => 'required|numeric',
            'type_person' => 'required|numeric',
            'category' => 'required|numeric',
        ], [], $customAttributes);

        try {
            $result = $this->supplierService->updateSupplier($input, $id_supplier);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Fornecedor atualizado com sucesso!'], 200);
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
            $result = $this->supplierService->deleteSupplier($id_supplier);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Fornecedor removido com sucesso!'], 200);
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
            $result = $this->supplierService->restoreSupplier($id_supplier);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Fornecedor restaurado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
