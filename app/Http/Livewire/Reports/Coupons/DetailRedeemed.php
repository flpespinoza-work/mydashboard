<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Http\Livewire\Reports\BaseCouponsReport;

class DetailRedeemed extends BaseCouponsReport
{
    public $reportName = 'reports.coupons.detail-redeemed';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.coupons.detail-redeemed');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getDetailRedeemedCoupons($filters);
    }
}
