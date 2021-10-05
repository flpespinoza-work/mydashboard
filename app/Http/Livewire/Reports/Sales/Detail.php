<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Exports\DetailSalesExport;
use App\Http\Livewire\Reports\BaseSalesReport;

class Detail extends BaseSalesReport
{
    public $reportName = 'reports.sales.detail';
    public $report_data;
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.sales.detail');
    }

    public function generateReport($filters)
    {
        $this->report_data['store'] = fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getDetailSales($filters);
    }

}
