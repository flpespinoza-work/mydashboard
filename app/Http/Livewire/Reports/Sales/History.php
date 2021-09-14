<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Http\Livewire\Reports\BaseSalesReport;

class History extends BaseSalesReport
{
    public $reportName = 'reports.sales.history';
    public $store_name;
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.sales.history');
    }

    public function generateReport($filters)
    {
        $this->store_name = fnGetStoreNAme($filters['store']);
        $this->result = $this->getHistorySales($filters);
    }
}
