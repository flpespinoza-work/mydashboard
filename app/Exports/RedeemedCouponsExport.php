<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RedeemedCouponsExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    use Exportable;

    protected $coupons;

    public function __construct($coupons)
    {
        $this->coupons = $coupons;
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
            'Fecha',
            'Cupones canjeados',
            'Monto'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE
        ];
    }
}
