<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseReport;

class Registers extends BaseReport
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
