<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\PeopleService;
use App\Models\Guarantor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuarantorController extends Controller
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
            $result = $this->peopleService->getGuarantors($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $guarantors = $result->getData();
            return response()->json(['guarantors' => $guarantors], 200);
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
            $result = $this->peopleService->saveGuarantor($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Fiador salvo com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_guarantor)
    {
        try {
            $result = $this->peopleService->getGuarantorById($id_guarantor);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $guarantor = $result->getData();
            return response()->json(['guarantor' => $guarantor], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_guarantor)
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
            $result = $this->peopleService->updateGuarantor($input, $id_guarantor);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Fiador atualizado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_guarantor)
    {
        try {
            $result = $this->peopleService->deleteGuarantor($id_guarantor);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Fiador removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_guarantor
     * @return JsonResponse
     */
    public function restore(string $id_guarantor): JsonResponse
    {
        try {
            $result = $this->peopleService->restoreGuarantor($id_guarantor);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Fiador restaurado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
