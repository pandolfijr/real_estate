<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell; 

class RelatorioExport implements FromCollection, WithCustomStartCell
{
    protected $data;
    protected $templatePath;
    protected $startCell;

    public function __construct(array $data,  string $startCell = 'A8', string $templatePath)
    {
        $this->data = $data;
        $this->startCell = $startCell;
        $this->templatePath = $templatePath;
    }

    /**
     *
     * @return string
     */
    public function startCell(): string
    {
        return $this->startCell;
    }

    /**
     *
     * @return string
     */
    public function template(): string
    {
        return $this->templatePath;
    }

    /**
     *
     * @return void
     */
    public function collection()
    {
        return collect($this->data);
    }
    
}
