<?php

namespace App\Interfaces\Repository;

use App\Helpers\Result;

interface SettingRepository
{
    public function getSettings(): Result;
    public function updateSetting(array $input, $id_setting): Result;
    public function getSettingById(string $id_setting): Result;
}
