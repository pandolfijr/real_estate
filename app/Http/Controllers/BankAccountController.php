<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\BankAccountService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    private $bankAccountService;
    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $input = $request->all();
            $result = $this->bankAccountService->getBankAccounts($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $bank_accounts = $result->getData();
            return response()->json(['bank_accounts' => $bank_accounts], 200);
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
            'bank_code' => 'código do banco',
            'bank_name' => 'nome do banco',
            'agency' => 'agência',
            'account' => 'número da conta',
            'account_type' => 'tipo da conta',
            'account_name' => 'descrição da conta'
        ];
        $request->validate([
            'bank_code' => 'required|string|max:10',
            'bank_name' => 'required|string|max:30',
            'agency' => 'required|string|max:10',
            'account' => 'required|string|max:15|unique:bank_accounts',
            'account_type' => 'required|numeric',
            'account_name' => 'required|string|max:30',
        ], [], $customAttributes);

        $input = $request->all();

        try {
            $result = $this->bankAccountService->saveBankAccount($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta Bancária salva com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_bank_account)
    {
        try {
            $result = $this->bankAccountService->getBankAccountById($id_bank_account);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $bank_account = $result->getData();
            return response()->json(['bank_account' => $bank_account], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_bank_account)
    {
        $input = $request->all();

        $customAttributes = [
            'bank_code' => 'código do banco',
            'bank_name' => 'nome do banco',
            'agency' => 'agência',
            'account' => 'número da conta',
            'account_type' => 'tipo da conta',
            'account_name' => 'descrição da conta'
        ];
        $request->validate([
            'bank_code' => 'required|string|max:10',
            'bank_name' => 'required|string|max:30',
            'agency' => 'required|string|max:10',
            'account' => 'required|string|max:15',
            'account_type' => 'required|numeric',
            'account_name' => 'required|string|max:30',
        ], [], $customAttributes);

        try {
            $result = $this->bankAccountService->updateBankAccount($input, $id_bank_account);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta Bancária atualizada com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_bank_account)
    {
        try {
            $result = $this->bankAccountService->deleteBankAccount($id_bank_account);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta Bancária removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_bank_account
     * @return JsonResponse
     */
    public function restore(string $id_bank_account): JsonResponse
    {
        try {
            $result = $this->bankAccountService->restoreBankAccount($id_bank_account);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta Bancária restaurado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function getCasherAccount(Request $request)
    {
        try {
            $input = $request->all();

            $result = $this->bankAccountService->getCasherAccount($input, true);

            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $casher_account = $result->getData();
            return response()->json(['casher_account' => $casher_account], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
