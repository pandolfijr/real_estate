<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\PeopleService;
use App\Models\Renter;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RenterController extends Controller
{
    private $peopleService;
    public function __construct(PeopleService $peopleService)
    {
        $this->peopleService = $peopleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $input = $request->all();
            $result = $this->peopleService->getRenters($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $renters = $result->getData();
            return response()->json(['renters' => $renters], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $customAttributes = [
            'income' => 'renda',
            'people.name' => 'nome',
            'people.surname' => 'sobrenome',
            'people.cellphone' => 'celular',
            'people.email' => 'e-mail',
            'people.address' => 'endereço',
            'people.id_city' => 'cidade',
        ];
        if ($request->id_people) {
            $request->validate([
                'income' => 'required|numeric|min:0',
            ], [], $customAttributes);
        } else {
            $request->validate([
                'people.name' => 'required|string|max:20',
                'people.surname' => 'required|string|max:70',
                'income' => 'required|numeric|min:0',
                'people.cpf' => 'nullable|string|max:11|unique:people',
                'people.rg' => 'nullable|string|max:11|unique:people',
                'people.cnpj' => 'nullable|string|max:14|unique:people',
                'people.cellphone' => 'required|unique:people|string|max:11',
                'people.email' => 'unique:people|nullable|string|email|max:140',
                'people.address' => 'required|string|max:255',
                'people.id_city' => 'required|numeric',
            ], [], $customAttributes);
        }

        $input = $request->all();

        try {
            $result = $this->peopleService->saveRenter($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Locatário salvo com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_renter)
    {
        try {
            $result = $this->peopleService->getRenterById($id_renter);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $renter = $result->getData();
            return response()->json(['renter' => $renter], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_renter)
    {
        $input = $request->all();

        $customAttributes = [
            'income' => 'renda',
            'people.name' => 'nome',
            'people.surname' => 'sobrenome',
            'people.cellphone' => 'celular',
            'people.email' => 'e-mail',
            'people.address' => 'endereço',
            'people.id_city' => 'cidade',
            'people.cpf' => 'cpf',
            'people.rg' => 'rg',
        ];
        $request->validate([
            'people.name' => 'required|string|max:20',
            'people.surname' => 'required|string|max:70',
            'income' => 'required|numeric|min:0',
            'people.cpf' => 'nullable|string|max:11|unique:people,cpf,' .  $input['people']['id'],
            'people.rg' => 'nullable|string|max:11|unique:people,rg,' .  $input['people']['id'],
            'people.cnpj' => 'nullable|string|max:14|unique:people,cnpj,' .  $input['people']['id'],
            'people.cellphone' => 'required|string|max:11|unique:people,cellphone,' . $input['people']['id'],
            'people.email' => 'nullable|string|email|max:140|unique:people,email,' . $input['people']['id'],
            'people.address' => 'required|string|max:255',
            'people.id_city' => 'required|numeric',
        ], [], $customAttributes);


        try {
            $result = $this->peopleService->updateRenter($input, $id_renter);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Locatário atualizado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_renter)
    {
        try {
            $result = $this->peopleService->deleteRenter($id_renter);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Locatário removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_renter
     * @return JsonResponse
     */
    public function restore(string $id_renter): JsonResponse
    {
        try {
            $result = $this->peopleService->restoreRenter($id_renter);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Locatário restaurado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function total()
    {
        try {
            $result = $this->peopleService->getTotalRenters();
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $renters = $result->getData();
            return response()->json(['renters' => $renters], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
