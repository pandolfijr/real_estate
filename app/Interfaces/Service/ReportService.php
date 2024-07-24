<?php

namespace App\Interfaces\Service;

use Illuminate\Database\Eloquent\Collection;

interface ReportService
{
    public function gerarRelatorio(Collection $data): void;
}
