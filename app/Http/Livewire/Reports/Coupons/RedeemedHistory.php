<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Http\Livewire\Reports\BaseCouponsReport;

class RedeemedHistory extends BaseCouponsReport
{
    public $reportName = 'reports.coupons.redeemed-history';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.coupons.redeemed-history');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getRedeemedHistoryCoupons($filters);
        //dd($this->result);
    }
}
