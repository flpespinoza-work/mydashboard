<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Traits\Reports\Coupons;
use App\Models\Store;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Redeemed extends Component
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

        if(!is_null($this->result))
        {
            $couponsChartModel = null;
            $ammountChartModel = null;

            $coupons = collect($this->result['coupons']);

            $couponsChartModel = $coupons->reduce(function (AreaChartModel $couponsChartModel, $data, $key) use($coupons) {
                $coupon = $coupons[$key];
                return $couponsChartModel->addPoint($key, $coupon['count']);
            }, (new AreaChartModel())
                ->setTitle('Cupones canjeados')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            $ammountChartModel = $coupons->reduce(function (AreaChartModel $ammountChartModel, $data, $key) use($coupons) {
                $coupon = $coupons[$key];
                return $ammountChartModel->addPoint($key, $coupon['ammount']);
            }, (new AreaChartModel())
                ->setTitle('Dinero canjeado')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
                ->setColor('#CF0924')
            );
            return view('livewire.reports.coupons.redeemed')->with(['stores' => $stores,'couponsChartModel' => $couponsChartModel, 'ammountChartModel' => $ammountChartModel]);
        }

        return view('livewire.reports.coupons.redeemed', compact('stores'));
    }

    public function generateReport()
    {
        $this->result = $this->getRedeemedCoupons($this->filters);
    }
}
