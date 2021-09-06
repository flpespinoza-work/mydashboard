<?php

namespace App\Http\Livewire\Reports\Coupons;

use Livewire\Component;
use App\Models\Store;
use App\Traits\Reports\Coupons;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class DetailRedeemed extends Component
{
    use Coupons;

    public $result = null;

    public $filters = [
        'store' => null,
        'initial_date' => null,
        'final_date' => null
    ];

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
