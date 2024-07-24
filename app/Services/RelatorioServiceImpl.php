<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

use App\Interfaces\Service\ReportService;

use App\Helpers\Utils;
use Illuminate\Database\Eloquent\Collection;

class RelatorioServiceImpl implements ReportService
{
    public function gerarRelatorio(Collection $data): void
    {
        $templatePath = public_path('templates/excel/relatorio.xlsx');
        $exportData = [];

        foreach ($data as $col) {
            $exportData[] = [
                $col->id,
                $col->referencia,
                $col->descricao,
                $col->finalidade,
                $col->status_imovel,
                $col->descricao_tipo_imoveis,
                $col->nome_proprietario . ' ' . $col->sobrenome_proprietario,
                Utils::mascaraCelular($col->celular_proprietario),
                $col->endereco,
                $col->cidade . '/' . $col->estado,
                $col->bairro
            ];
        }
        $templatePath = public_path('templates/relatorio.xlsx');
        $reader = new Xlsx();
        $spreadsheet = $reader->load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($exportData, null, 'A8');
        $writer = new WriterXlsx($spreadsheet);
        $writer->save(storage_path('app/public/Relatório de Imóveis.xlsx'));
    }
}
