<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Exports\DetailSalesExport;
use App\Http\Livewire\Reports\BaseSalesReport;

class Detail extends BaseSalesReport
{
    public $reportName = 'reports.sales.detail';
    public $store_name;
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.sales.detail');
    }

    public function generateReport($filters)
    {
        $this->store_name = fnGetStoreNAme($filters['store']);
        $this->result = $this->getDetailSales($filters);
        //dd($this->result);
    }

    public function exportReport()
    {
        return (new DetailSalesExport(collect($this->result['REGISTROS'])))->download('reporte_ventas_detalle.xlsx');
    }
}
