<?php

namespace App\Http\Livewire\Reports\Balance;

use App\Http\Livewire\Reports\BaseBalanceReport;
use App\Traits\Reports\Balance as ReportsBalance;

class Balance extends BaseBalanceReport
{
    use ReportsBalance;

    public $result = null;

    public function render()
    {
        $this->result =  $this->getStoresBalance();
        //dd($this->result);
        return view('livewire.reports.balance.balance');
    }
}
