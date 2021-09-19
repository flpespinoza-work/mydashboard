<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GlobalsRedeemsExport implements
FromCollection,
WithHeadings,
ShouldAutoSize,
WithMapping,
WithStyles
{
    use Exportable;

    protected $redeems, $report_data, $days, $count, $stores_names;

    public function __construct($days, $redeems, $report_data)
    {
        $this->days = $days;
        $this->redeems = $redeems;
        $this->report_data = $report_data;
        $this->count = 0;
        $this->stores_names = array_keys($redeems->toArray());
    }

    public function collection()
    {
        return $this->redeems;
    }

    public function headings(): array
    {
        $headers = [
            [
                'Reporte de global de canjes diarios'
            ],
            [
                'Establecimiento: ' . $this->report_data['store']
            ],
            [
                $this->report_data['period']
            ]
        ];

        $h = ['Establecimiento'];
        foreach($this->days as $day)
        {
            $h[] = $day;
        }

        array_push($headers, $h);
        return $headers;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            4 => ['font' => ['bold' => true]]
        ];
    }


    public function map($row): array
    {
        $redeems[] = $this->stores_names[$this->count];
        foreach($row as $data)
        {
            $redeems[] = $data;
        }
        $this->count++;
        return $redeems;
    }
}
