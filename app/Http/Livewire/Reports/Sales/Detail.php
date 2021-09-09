<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Http\Livewire\Reports\BaseReport;

class Detail extends BaseReport
{
    public $reportName = 'reports.sales.detail';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.sales.detail');
    }

    public function generateReport($filters)
    {

    }
}
