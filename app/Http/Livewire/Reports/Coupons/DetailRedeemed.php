<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Http\Livewire\Reports\BaseReport;
use App\Models\Store;

class DetailRedeemed extends BaseReport
{
    public function render()
    {
        $stores = Store::orderBy('name')->pluck('name', 'id');
        return view('livewire.reports.coupons.detail-redeemed', compact('stores'));
    }

    public function generateReport()
    {
        $this->result = $this->getDetailRedeemedCoupons($this->filters);
    }
}
