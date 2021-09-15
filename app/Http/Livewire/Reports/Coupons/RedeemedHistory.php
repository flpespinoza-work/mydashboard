<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Http\Livewire\Reports\BaseCouponsReport;

class RedeemedHistory extends BaseCouponsReport
{
    public $reportName = 'reports.coupons.redeemed-history';
    public $store_name;
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.coupons.redeemed-history');
    }

    public function generateReport($filters)
    {
        $this->store_name = fnGetStoreNAme($filters['store']);
        $this->result['printed'] = $this->getPrintedHistoryCoupons($filters);
        $this->result['redeems'] = $this->getRedeemedHistoryCoupons($filters);
    }
}
