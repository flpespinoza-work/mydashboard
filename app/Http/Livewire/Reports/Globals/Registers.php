<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseGlobalsReport;
use App\Traits\Reports\Globals;

class Registers extends BaseGlobalsReport
{
    use Globals;

    public $reportName = 'reports.globals.registers';
    protected $listeners = ['generateReport'];
    public $result = null;

    public function render()
    {
        return view('livewire.reports.globals.registers');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getRegisters($filters);
        //dd($this->result);
    }
}
