<?php

namespace App\Interfaces\Repository;

use App\Helpers\Result;
use App\Models\User;

interface UserRepository
{
    public function getUsers(array $input, bool $paginate): Result;
    public function getTotalUsers(): Result;
    public function saveUser(array $input): Result;
    public function updateUser(array $input, string $id_property): Result;
    public function getUserById(string $id): Result;
    public function deleteUser(string $id_user): Result;
    public function restoreUser(string $id_user): Result;
}
