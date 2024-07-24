<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\CheckService;
use App\Models\Check;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    private $checkService;
    public function __construct(CheckService $checkService)
    {
        $this->checkService = $checkService;
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
            $result = $this->checkService->getChecks($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $cities = $result->getData();
            return response()->json(['checks' => $cities], 200);
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
        $customAttributes = [
            'issuance_date' => 'data de emissão',
            'due_date' => 'data de vencimento',
            'bank_name' => 'nome do banco',
            'favored_name' => 'nome do favorecido',
            'type' => 'tipo',
        ];
        $request->validate([
            'issuance_date' => 'required',
            'due_date' => 'required',
            'bank_name' => 'required|string|max:30',
            'favored_name' => 'required|string|max:80',
            'status' => 'required|numeric',
            'type' => 'required|numeric',
        ], [], $customAttributes);

        $input = $request->all();
        try {
            $result = $this->checkService->saveCheck($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Cheque salva com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


        /**
     * Display the specified resource.
     */
    public function show($id_check)
    {
        try {
            $result = $this->checkService->getCheckById($id_check);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $check = $result->getData();
            return response()->json(['check' => $check], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param Request $request
     * @param string $id_check
     * @return void
     */
    public function update(Request $request, string $id_check)
    {
        $customAttributes = [
            'issuance_date' => 'data de emissão',
            'due_date' => 'data de vencimento',
            'bank_name' => 'nome do banco',
            'favored_name' => 'nome do favorecido',
            'type' => 'tipo',
        ];
        $request->validate([
            'issuance_date' => 'required',
            'due_date' => 'required',
            'bank_name' => 'required|string|max:30',
            'favored_name' => 'required|string|max:80',
            'status' => 'required|numeric',
            'type' => 'required|numeric',
        ], [], $customAttributes);

        $input = $request->all();
        try {
            $result = $this->checkService->updateCheck($input, $id_check);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Cheque alterada com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_check
     * @return JsonResponse
     */
    public function destroy(string $id_check): JsonResponse
    {
        try {
            $result = $this->checkService->deleteCheck($id_check);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['message' => 'Cheque removida com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
