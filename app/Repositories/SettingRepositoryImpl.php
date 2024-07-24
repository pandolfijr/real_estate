<?php

namespace App\Repositories;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\SettingRepository;
use App\Models\Setting;

class SettingRepositoryImpl implements SettingRepository
{
    public function getSettings(): Result
    {
        try {
            $settings = Setting::first();
            if (!$settings)
                return Result::error(
                    new ErrorApplication(
                        'SettingRepositoryImpl > getSettings',
                        'Erro ao buscar configurações',
                        400,
                    )
                );
            return Result::success($settings);
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SettingRepositoryImpl > getSettings',
                    'Erro ao buscar configurações: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function updateSetting(array $input, $id_setting): Result
    {
        try {
            $settings = Setting::where('id', $id_setting)->first();
            $settings->fill($input);
            $settings->update();

            return Result::success();
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SettingRepositoryImpl > updateSetting',
                    'Erro ao salvar configuração: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
    public function getSettingById(string $id_setting): Result
    {
        try {
            $settings = Setting::where('id', $id_setting)->first();
            if (!$settings)
                return Result::error(
                    new ErrorApplication(
                        'SettingRepositoryImpl > getSettingById',
                        'Erro ao buscar configurações',
                        400,
                    )
                );
            return Result::success($settings);
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SettingRepositoryImpl > getSettingById',
                    'Erro ao buscar configurações: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }
}
