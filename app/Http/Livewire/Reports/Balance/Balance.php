<?php

namespace App\Http\Livewire\Reports\Balance;

use App\Http\Livewire\Reports\BaseBalanceReport;

class Balance extends BaseBalanceReport
{
    public $reportName = 'reports.coupons.printed';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.balance.balance');
    }

    public function generateReport()
    {

    }
}
