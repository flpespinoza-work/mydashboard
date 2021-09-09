<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseGlobalsReport;

class Redeems extends BaseGlobalsReport
{
    public $reportName = 'reports.globals.redeems';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.globals.redeems');
    }

    public function generateReport($filters)
    {

    }
}
