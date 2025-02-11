<?php

namespace App\Exports;

use App\Models\CFISModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CadidateReportExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $columns;

    public function __construct($data, $columns)
    {
        $this->data = $data;
        $this->columns = $columns;
    }

    /**
     * Return the data collection for export.
     */
    public function collection()
    {
        return $this->data->map(function ($row) {
            return collect($row)->only($this->columns);
        });
    }

    /**
     * Return column headings.
     */
    public function headings(): array
    {
        return array_map(function ($column) {
            return ucwords(str_replace('_', ' ', $column)); // Format column names
        }, $this->columns);
    }
}
