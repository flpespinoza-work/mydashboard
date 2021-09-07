<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Http\Livewire\Reports\BaseReport;

class DetailRedeemed extends BaseReport
{
    public $reportName = 'reports.coupons.detail-printed';
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
