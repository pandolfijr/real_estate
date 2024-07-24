<?php

namespace App\Interfaces\Service;

use App\Helpers\Result;
use App\Models\User;

interface UserService
{
    public function getUsers(array $data, bool $paginate): Result;
    public function getTotalUsers(): Result;
    public function saveUser(array $input): Result;
    public function updateUser(array $input, string $id_user): Result;
    public function getUserById(string $id): Result;
    public function deleteUser(string $id_user): Result;
    public function restoreUser(string $id_user): Result;
}
