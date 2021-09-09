<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseGlobalsReport;

class Registers extends BaseGlobalsReport
{
    public $reportName = 'reports.globals.registers';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.globals.registers');
    }

    public function generateReport($filters)
    {

    }
}
