<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Http\Livewire\Reports\BaseSalesReport;

class Sales extends BaseSalesReport
{
    public $reportName = 'reports.sales.sales';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.sales.sales');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getSales($filters);
    }
}
