<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PrintedCouponsExport implements
FromCollection,
WithHeadings,
WithColumnFormatting,
WithMapping,
WithProperties,
ShouldAutoSize,
WithStyles
{
    use Exportable;

    protected $coupons, $report_data;

    public function __construct($coupons, $report_data)
    {
        $this->coupons = $coupons;
        $this->report_data = $report_data;
    }

    public function properties(): array
    {
        return [
            'title' => 'Reporte de cupones impresos',
            'subject' => 'Reportes',
            'company' => 'Tokencash'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            4 => ['font' => ['bold' => true]]
        ];
    }

    public function collection()
    {
        return $this->coupons;
    }

    public function map($row): array
    {
        return [
            $row['day'],
            $row['count'],
            $row['amount'],
            number_format($row['amount'] / $row['count'],2),
            $row['aggr']
        ];
    }

    public function headings(): array
    {
        return
        [
            [
                'Reporte de cupones impresos'
            ],
            [
                'Establecimiento: ' . $this->report_data['store']
            ],
            [
                $this->report_data['period']
            ],
            [
                'Fecha',
                'Cupones impresos',
                'Monto',
                'Cupon promedio',
                'Acumulado'
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'D' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'E' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE
        ];
    }
}
