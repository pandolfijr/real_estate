<?php

namespace App\Services;

use App\Helpers\ErrorApplication;
use App\Helpers\Result;
use App\Interfaces\Repository\SettingRepository;
use App\Interfaces\Service\SettingService;
use App\Models\Setting;
use App\Helpers\Utils;
use Illuminate\Support\Facades\DB;

class SettingServiceImpl implements SettingService
{
    private $settingRepository;
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }
    public function getSettings(): Result
    {
        return $this->settingRepository->getSettings();
    }
    public function updateSetting(array $input, $id_setting): Result
    {
        try {
            return DB::transaction(function () use ($input, $id_setting) {

                // $this->handleImageUpload('logo_menu', $id_setting, $input);
                // $this->handleImageUpload('logo_icone', $id_setting, $input);

                $this->settingRepository->updateSetting($input, $id_setting);
                return Result::success();
            });
        } catch (\Exception $e) {
            return Result::error(
                new ErrorApplication(
                    'SettingServiceImpl > updateSetting',
                    'Erro ao salvar configuração: ' . $e->getMessage(),
                    500,
                )
            );
        }
    }

    private function verificaDiretorioImagem($referencia): void
    {
        if (!is_dir(Setting::SETTINGS_FOLDER . $referencia))
            mkdir(Setting::SETTINGS_FOLDER . $referencia, 0755, true);
    }

    public function handleImageUpload($fieldName, $idSetting, array &$input)
    {
        // Verifica se o campo de arquivo está presente nos dados da requisição
        if ($input[$fieldName]) {
            // Obtém o arquivo do campo de arquivo
            $imagem = $input[$fieldName];

            // Verifica o diretório da imagem
            $this->verificaDiretorioImagem($idSetting);

            // Define o nome do arquivo com base no ID da configuração e na data atual
            $filename = $fieldName . '_' . $idSetting . '_' . date('Ymd') . '.' . $imagem->getClientOriginalExtension();

            // Move o arquivo para o diretório adequado
            $imagem->move(Setting::SETTINGS_FOLDER . $idSetting, $filename);

            // Atualiza o atributo correspondente no objeto de configuração
            $input[$fieldName] = $filename;
        }
    }

    public function getSettingById(string $id_setting): Result
    {
        return $this->settingRepository->getSettingById($id_setting);
    }
}
