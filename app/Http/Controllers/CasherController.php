<?php

namespace App\Http\Controllers;

use App\Models\Casher;
use Illuminate\Http\Request;
use App\Interfaces\Service\BankAccountService;
use Exception;

class CasherController extends Controller
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
            $result = $this->bankAccountService->getCasherAccounts($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $casher = $result->getData();
            return response()->json(['cash_registers' => $casher], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_bank_account, Request $request)
    {
        try {
            $input = $request->all();
            $result = $this->bankAccountService->getCasherBankAccountById($id_bank_account, $input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $bank_account = $result->getData();
            return response()->json(['cash_registers' => $bank_account], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Casher $casher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Casher $casher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Casher $casher)
    {
        //
    }
}
