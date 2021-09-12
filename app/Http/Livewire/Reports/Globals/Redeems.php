<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseGlobalsReport;
use App\Traits\Reports\Globals;

class Redeems extends BaseGlobalsReport
{
    use Globals;
    public $reportName = 'reports.globals.redeems';
    protected $listeners = ['generateReport'];
    public $result = null;

    public function render()
    {
        return view('livewire.reports.globals.redeems');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getRedeems($filters);
    }
}
