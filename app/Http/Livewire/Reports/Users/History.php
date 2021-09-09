<?php

namespace App\Http\Livewire\Reports\Users;

use App\Http\Livewire\Reports\BaseReport;

class History extends BaseReport
{
    public $reportName = 'reports.users.history';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.users.history');
    }

    public function generateReport($filters)
    {

    }
}
