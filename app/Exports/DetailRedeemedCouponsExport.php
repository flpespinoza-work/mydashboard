<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetailRedeemedCouponsExport implements
FromCollection,
WithHeadings,
WithColumnFormatting,
ShouldAutoSize,
WithStyles
{
    use Exportable;

    private $coupons, $report_data;

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

    public function headings(): array
    {
        return [
            [
                'Reporte de cupones impresos',
            ],
            [
                'Establecimiento: ' . $this->report_data['store']
            ],
            [
                $this->report_data['period']
            ],
            [
                'Usuario',
                'Cupón',
                'Fecha impresión',
                'Fecha canje',
                'Monto',
                'Saldo usuario'
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'F' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            4 => ['font' => ['bold' => true]]
        ];
    }
}
