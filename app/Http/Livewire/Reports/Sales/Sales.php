<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Http\Livewire\Reports\BaseReport;

class Sales extends BaseReport
{
    public $reportName = 'reports.sales.sales';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.sales.sales');
    }

    public function generateReport($filters)
    {

    }
}
