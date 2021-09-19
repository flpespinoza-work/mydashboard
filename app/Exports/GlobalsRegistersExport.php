<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GlobalsRegistersExport implements
FromCollection,
WithHeadings,
WithStyles,
WithMapping,
ShouldAutoSize
{

    use Exportable;

    protected $users, $report_data, $count, $days, $stores_names;

    public function __construct($days, $users, $report_data)
    {
        $this->days = $days;
        $this->users = $users;
        $this->report_data = $report_data;
        $this->count = 0;
        $this->stores_names = array_keys($users->toArray());
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        $headers = [
            [
                'Reporte de global de altas diarias'
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
        $registers[] = $this->stores_names[$this->count];
        foreach($row as $data)
        {
            $registers[] = $data;
        }
        $this->count++;
        return $registers;
    }
}
