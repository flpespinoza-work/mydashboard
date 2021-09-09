<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Http\Livewire\Reports\BaseSalesReport;

class Detail extends BaseSalesReport
{
    public $reportName = 'reports.sales.detail';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.sales.detail');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getDetailSales($filters);
    }
}
