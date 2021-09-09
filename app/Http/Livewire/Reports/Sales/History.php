<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Http\Livewire\Reports\BaseSalesReport;

class History extends BaseSalesReport
{
    public $reportName = 'reports.sales.history';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.sales.history');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getHistorySales($filters);
    }
}
