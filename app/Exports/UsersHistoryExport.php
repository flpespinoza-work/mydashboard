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

class UsersHistoryExport implements
FromCollection,
WithHeadings,
WithColumnFormatting,
WithStyles,
ShouldAutoSize,
WithMapping
{
    use Exportable;

    protected $users, $store;

    public function __construct($users, $store)
    {
        $this->users = $users;
        $this->store = $store;
    }

    public function collection()
    {
        return $this->users;
    }

    public function headings(): array
    {
        return
        [
            [
                'Reporte acumulado de usuarios',
            ],
            [
                'Establecimiento: ' . $this->store
            ],
            [
                'Usuarios',
                'Saldo actual en monedeeros',
                'Monedero promedio por usuario'
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'B' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'C' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            3 => ['font' => ['bold' => true]]
        ];
    }

    public function map($row): array
    {
        return
        [
            $row['users'],
            $row['amount'],
            number_format($row['avg'],2)
        ];
    }
}
