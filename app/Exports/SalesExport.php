<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithStyles, WithMapping
{
    use Exportable;

    protected $sales, $report_data;

    public function __construct($sales, $report_data)
    {
        $this->sales = $sales;
        $this->report_data = $report_data;
    }

    public function collection()
    {
        return $this->sales;
    }

    public function map($row): array
    {
        return [
            $row['date'],
            $row['sales'],
            $row['amount'],
            number_format($row['amount'] / $row['sales'],2)
        ];
    }

    public function headings(): array
    {
        return
        [
            [
                'Reporte de ventas realizadas',
            ],
            [
                'Establecimiento: ' . $this->report_data['store']
            ],
            [
                $this->report_data['period']
            ],
            [
                'Fecha',
                'Ventas',
                'Monto',
                'Venta promedio'
            ]
        ];
    }

    public function columnFormats(): array
    {
        return
        [
            'C' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'D' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            4 => ['font' => ['bold' => true]]
        ];
    }
}
