<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\AccountService;
use App\Models\AccountPayReceive;
use App\Models\Installment;
use Exception;
use Illuminate\Http\Request;

class InstallmentController extends Controller
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
            $result = $this->accountService->getInstallments($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $installments = $result->getData();
            return response()->json(['installments' => $installments], 200);
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
    public function store()
    {
    }

    /**
     * Display the specified resource.
     */
    public function show($id_installment)
    {
        try {
            $result = $this->accountService->getInstallmentById($id_installment);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $installment = $result->getData();
            return response()->json(['installment' => $installment], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Installment $installment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_installment)
    {
        $input = $request->all();

        $customAttributes = [
            'description' => 'descrição',
            'installment_value' => 'valor parcela',
            'installment_total_value' => 'valor final',
            'payment_method' => 'método de pagamento',
        ];
        $request->validate([
            'description' => 'required|string|max:80',
            'installment_value' => 'required|numeric',
            'installment_total_value' => 'required|numeric',
            'status' => 'required|numeric',
            'payment_method' => 'required|numeric',
        ], [], $customAttributes);

        try {
            $result = $this->accountService->updateInstallment($input, $id_installment);
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
    public function destroy(Installment $installment)
    {
        //
    }

    public function sendTransfer(Request $request, string $id_installment)
    {
        $input = $request->all();
        $customAttributes = [
            'transfer_value' => 'valor repasse',
        ];
        $request->validate([
            'transfer_value' => 'required|numeric',
        ], [], $customAttributes);

        try {
            $result = $this->accountService->sendTransfer($input, $id_installment); // fazer
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta atualizada com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
