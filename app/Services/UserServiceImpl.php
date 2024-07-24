<?php

namespace App\Services;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;

use App\Interfaces\Repository\UserRepository;
use App\Interfaces\Service\UserService;
use App\Models\User;
use App\Helpers\Utils;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function getUsers(array $input, bool $paginate): Result
    {
        return $this->userRepository->getUsers($input, $paginate);
    }

    public function getTotalUsers(): Result
    {
        return $this->userRepository->getTotalUsers();
    }

    public function saveUser(array $input): Result
    {
        try {
            $input['cellphone'] = Utils::limpaCpfCnpjCep($input['cellphone']);
            $input['cpf'] = Utils::limpaCpfCnpjCep($input['cpf']);
            $input['password'] = Hash::make($input['password']);
            $this->userRepository->saveUser($input);
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'UserService > saveUser',
                    'Erro ao salvar usuário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function updateUser(array $input, string $id_user): Result
    {
        try {
            $input['cellphone'] = Utils::limpaCpfCnpjCep($input['cellphone']);
            $input['cpf'] = Utils::limpaCpfCnpjCep($input['cpf']);
            if (!empty($input['password']))
                $input['password'] = Hash::make($input['password']);

            $this->userRepository->updateUser($input, $id_user);
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'PropertyRepository > saveProperty',
                    'Erro ao salvar imóvel: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    public function getUserById(string $id): Result
    {
        return $this->userRepository->getUserById($id);
    }

    public function deleteUser(string $id_user): Result
    {
        return $this->userRepository->deleteUser($id_user);
    }

    public function restoreUser(string $id_user): Result
    {
        return $this->userRepository->restoreUser($id_user);
    }
}
