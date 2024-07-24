<?php

namespace App\Interfaces\Repository;

use App\Helpers\Result;

interface CheckRepository
{
    public function getChecks(array $data, bool $paginate = false): Result;
    public function saveCheck(array $input): Result;
    public function updateCheck(array $input, string $id_check): Result;
    public function getCheckById(string $id): Result;
    public function deleteCheck(string $id_check): Result;
    public function restoreCheck(string $id_check): Result;
}
