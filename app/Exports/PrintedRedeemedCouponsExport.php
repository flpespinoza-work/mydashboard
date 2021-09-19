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

class PrintedRedeemedCouponsExport implements
FromCollection,
WithHeadings,
WithColumnFormatting,
WithMapping,
WithStyles,
ShouldAutoSize
{
    use Exportable;

    protected $coupons, $report_data;

    public function __construct($coupons, $report_data)
    {
        $this->coupons = $coupons;
        $this->report_data = $report_data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->coupons;
    }

    public function styles(Worksheet $sheet)
    {
        return
        [
            4 => ['font' => ['bold' => true]]
        ];
    }

    public function map($row): array
    {
        return [
            $row['day'],
            $row['printed'],
            $row['redeemed'],
            $row['printed_amount'],
            $row['redeemed_amount']
        ];
    }

    public function headings(): array
    {
        return
        [
            [
                'Reporte de cupones impresos vs canjeados',
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
                'Cupones canjeados',
                'Monto impreso',
                'Monto canjeado'
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'E' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE
        ];
    }
}
