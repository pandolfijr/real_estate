<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\AccountService;
use App\Models\AccountPayReceive;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountReceiveController extends Controller
{

    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $input = $request->all();
            $input['type'] = AccountPayReceive::TO_RECEIVE;
            $result = $this->accountService->getAccounts($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $accounts = $result->getData();
            return response()->json(['accounts' => $accounts], 200);
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
            'description' => 'descrição',
            'original_value' => 'valor original',
            'type' => 'tipo',
            'id_supplier' => 'Fornecedor',
            'discharge_date' => 'data de quitação'
        ];

        $request->validate([
            'description' => 'required|string|max:80',
            'original_value' => 'required|numeric',
            'type' => 'required|numeric',
            'status' => 'required|numeric',
            'id_supplier' => 'required|numeric',
        ], [], $customAttributes);

        $input = $request->all();

        try {
            $result = $this->accountService->saveAccount($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta salva com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_account)
    {
        try {
            $result = $this->accountService->getAccountById($id_account);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $account = $result->getData();
            return response()->json(['account' => $account], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_account)
    {
        $input = $request->all();

        $customAttributes = [
            'description' => 'descrição',
            'original_value' => 'valor original',
            'type' => 'tipo',
            'id_supplier' => 'Fornecedor',
        ];
        $request->validate([
            'description' => 'required|string|max:80',
            'original_value' => 'required|numeric',
            'type' => 'required|numeric',
            'status' => 'required|numeric',
            // 'id_supplier' => 'required|numeric',
        ], [], $customAttributes);

        try {
            $result = $this->accountService->updateAccount($input, $id_account);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta atualizada com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_account)
    {
        try {
            $result = $this->accountService->deleteAccount($id_account);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_account
     * @return JsonResponse
     */
    public function restore(string $id_account): JsonResponse
    {
        try {
            $result = $this->accountService->restoreAccount($id_account);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta restaurado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
