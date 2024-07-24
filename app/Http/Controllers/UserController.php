<?php

namespace App\Http\Controllers;

use App\Interfaces\Service\UserService;
use App\Models\TipoUser;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Helpers\Utils;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $input = $request->all();
            $result = $this->userService->getUsers($input, true);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $users = $result->getData();
            return response()->json(['users' => $users, 'my_id' => Auth::user()->id], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3|max:20',
            'cellphone' => 'required|min:14',
            'cpf' => 'required|min:14',
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);

        $input = $request->all();
        try {
            $result = $this->userService->saveUser($input);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(["message" => "Usuário salvo com sucesso!"], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show(string $user_id): JsonResponse
    {
        try {
            $result = $this->userService->getUserById($user_id);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());
            $user = $result->getData();
            return response()->json(['user' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id_user)
    {

        $request->validate([
            'name' => 'required|min:3|max:20',
            'cellphone' => 'required|min:14',
            'cpf' => 'required|min:14',
            'email' => 'email|required',
            'password' => 'nullable|min:4'
        ]);

        $input = $request->all();
        try {
            $result = $this->userService->updateUser($input, $id_user);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(["message" => "Usuário alterado com sucesso!"], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_user
     * @return JsonResponse
     */
    public function destroy(string $id_user): JsonResponse
    {
        try {
            $result = $this->userService->deleteUser($id_user);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['Usuário removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     *
     * @param string $id_user
     * @return JsonResponse
     */
    public function restore(string $id_user): JsonResponse
    {
        try {
            $result = $this->userService->restoreUser($id_user);
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            return response()->json(['Imóvel removido com sucesso!'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function total()
    {
        try {
            $result = $this->userService->getTotalUsers();
            if (!$result->isSuccess())
                return response()->json(['message' => $result->getError()->getMessage()], $result->getError()->getCode());

            $users = $result->getData();
            return response()->json(['users' => $users], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
