<?php

namespace App\Http\Livewire\Reports\Users;

use App\Http\Livewire\Reports\BaseReport;

class NewUsers extends BaseReport
{
    public $reportName = 'reports.users.new-users';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.users.new-users');
    }

    public function generateReport($filters)
    {

    }
}
