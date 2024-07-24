<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Events\RelatorioEvent;
use App\Exports\RelatorioExport;
use App\Interfaces\Service\PropertyService;
use App\Interfaces\Service\ReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Utils;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

class ReportController extends Controller
{
    private $propertyService;
    private $reportService;
    public function __construct(
        PropertyService $propertyService,
        ReportService $reportService
    ) {
        $this->propertyService = $propertyService;
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        $input = $request->all();
        if (!empty($input)) {
            $result = $this->propertyService->getProperties($input, false);
            if(!$result->isSuccess())
                return response()->json(['message' => 'Não foi possível buscar os imóveis'],400);

            $output = $result->getData();
            $this->reportService->gerarRelatorio($output);
            return response()->download(storage_path('app/public/Relatório de Imóveis.xlsx'))->deleteFileAfterSend();
        }
        $cidades = City::all();
        return route('dashboard.relatorios.index', ['cidades' => $cidades]);
    }

}
