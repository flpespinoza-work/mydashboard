<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Http\Livewire\Reports\BaseReport;
use App\Models\Store;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class PrintedRedeemed extends BaseReport
{

    public function render()
    {
        $stores = Store::orderBy('name')->pluck('name', 'id');

        if(!is_null($this->result))
        {
            $couponsChartModel = null;

            $coupons = collect($this->result['coupons']);
            $couponsChartModel = $coupons->reduce(function (LineChartModel $couponsChartModel, $data, $key) use($coupons) {
                $coupon = $coupons[$key];
                $couponsChartModel->addSeriesPoint('Cupones impresos', $key, $coupon['printed']);

                if(isset($coupon['redeemed']))
                    $couponsChartModel->addSeriesPoint('Cupones canjeados', $key, $coupon['redeemed']);
                else
                    $couponsChartModel->addSeriesPoint('Cupones canjeados', $key, 0);

                return $couponsChartModel;

            }, (new LineChartModel())
                ->setTitle('Cupones impresos y canjeados')
                ->multiLine()
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
                ->setColors(['#E86300', '#FFA35E'])
            );

            return view('livewire.reports.coupons.printed-redeemed')->with(['stores' => $stores,'couponsChartModel' => $couponsChartModel]);
        }

        return view('livewire.reports.coupons.printed-redeemed', compact('stores'));
    }

    public function generateReport()
    {
        $this->result = $this->getPrintedRedeemedCoupons($this->filters);
    }
}
