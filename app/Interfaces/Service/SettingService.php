<?php

namespace App\Interfaces\Service;

use App\Helpers\Result;

interface SettingService
{
    public function getSettings(): Result;
    public function updateSetting(array $input, $id_setting): Result;
    public function getSettingById(string $id_setting): Result;
}
