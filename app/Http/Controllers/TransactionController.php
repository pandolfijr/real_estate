<?php

namespace App\Http\Controllers;


use App\Interfaces\Service\TransactionService;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class TransactionController extends Controller
{
    private $transactionService;
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $input = $request->all();
            $result = $this->transactionService->getTransactions($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $transactions = $result->getData();
            return response()->json(['transactions' => $transactions], 200);
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
            'id_locator' => 'Proprietário do Imóvel',
            'id_renter' => 'Locatário',
            'property_value' => 'Valor da Propriedade',
            'final_value' => 'Valor Final',
            'type_of_charge' => 'Tipo de Pagamento',
            'due_day' => 'Dia de Pagamento',
            'modality' => 'Modalidade',
            'id_broker' =>  'Corretor'
        ];
        $request->validate([
            'id_locator' => 'required',
            'id_renter' => 'required',
            'property_value' => 'required',
            'final_value' => 'required',
            'type_of_charge' => 'required',
            'due_day' => 'required',
            'modality' => 'required',
            'id_broker' => 'required'
        ], [], $customAttributes);

        $input = $request->all();

        try {
            $result = $this->transactionService->saveTransaction($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Transação salva com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id_transaction)
    {
        try {
            $result = $this->transactionService->getTransactionById($id_transaction);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $transaction = $result->getData();
            return response()->json(['transaction' => $transaction], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_transaction)
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
            $result = $this->transactionService->updateTransaction($input, $id_transaction);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Transação atualizado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_transaction)
    {
        try {
            $result = $this->transactionService->deleteTransaction($id_transaction);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Transação removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_transaction
     * @return JsonResponse
     */
    public function restore(string $id_transaction): JsonResponse
    {
        try {
            $result = $this->transactionService->restoreTransaction($id_transaction);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Transação restaurado com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function cancelTransaction(Request $request, string $id_installment)
    {
        $input = $request->all();
        try {
            $result = $this->transactionService->cancelTransaction($input, $id_installment); // fazer
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Conta atualizada com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
