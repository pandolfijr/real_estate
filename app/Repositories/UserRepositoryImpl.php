<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\UserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepositoryImpl implements UserRepository
{
    /**
     *
     * @param array $input
     * @param boolean $paginate
     * @return Result
     */
    public function getUsers(array $input, bool $paginate): Result
    {
        try {
            $users = $paginate
                ? $this->queryUsers($input)->paginate(30)
                : $this->queryUsers($input)->get();
            return Result::success($users);
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'UserRepository > getUsers',
                    'Erro ao buscar usuários',
                    500,
                )
            );
        }
    }

    public function getTotalUsers(): Result
    {
        try {
            $users = User::count();
            return Result::success($users);
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'UserRepository > getTotalUsers',
                    'Erro ao buscar total usuários',
                    500,
                )
            );
        }
    }

    /**
     *
     * @param array $input
     * @return Builder
     */
    private function queryUsers(array $input): Builder
    {
        try {
            $db = User::orderBy('name')->where('id', '!=', 1);
            if (isset($input['search'])) {
                $db->where(function ($q) use ($input) {
                    $q->where('name', 'LIKE', '%' . $input['search'] . '%')
                        ->orWhere('email', 'LIKE', '%' . $input['search'] . '%');
                });
            }

            if (isset($input['status']) && !empty($input['status'])) {
                $db->where('status', $input['status']);
                if ($input['status'] == User::INACTIVE)  // inativos
                    $db->onlyTrashed();
                elseif ($input['status'] == User::ALL)
                    $db->withTrashed(); // todos
            }

            return $db;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro'], 500);
        }
    }

    /**
     *
     * @param array $input
     * @return Result
     */
    public function saveUser(array $input): Result
    {
        try {
            $user = new User();
            $user->fill($input);
            $user->save();
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'UserRepository > saveUser',
                    'Erro ao salvar usuário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param array $input
     * @param string $id_user
     * @return Result
     */
    public function updateUser(array $input, string $id_user): Result
    {
        try {
            $user = User::where('id', $id_user)->first();
            $user->fill($input);
            $user->save();

            return Result::success([
                'dispatch' => ($input['status'] != $user['status']),
                'previous' => $user['status'],
                'current' => $input['status'],
            ]);
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'UserRepository > updateUser',
                    'Erro ao atualizar usuário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param string $id_user
     * @return Result
     */
    public function deleteUser(string $id_user): Result
    {
        try {
            $city = User::where('id', $id_user)->first();
            $city->delete();
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'UserRepository > deleteUser',
                    'Erro ao remover usuário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param string $id_user
     * @return Result
     */
    public function restoreUser(string $id_user): Result
    {
        try {
            $city = User::where('id', $id_user)->first();
            $city->restore();
            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'UserRepository > restoreUser',
                    'Erro ao restaurar usuário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    /**
     *
     * @param string $id
     * @return User
     */
    public function getUserById(string $id): Result
    {
        try {
            $user = User::where('id', $id)->withTrashed()->first();
            return Result::success($user);
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'UserRepository > getUserById',
                    'Erro ao restaurar usuário: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
}
