<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\RedeemedCouponsExport;
use App\Http\Livewire\Reports\BaseCouponsReport;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Redeemed extends BaseCouponsReport
{
    public $reportName = 'reports.coupons.redeemed';
    protected $listeners = ['generateReport'];

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $couponsChartModel = null;
            $amountChartModel = null;

            $coupons = collect($this->result['coupons']);

            $couponsChartModel = $coupons->reduce(function (AreaChartModel $couponsChartModel, $data, $key) use($coupons) {
                $coupon = $coupons[$key];
                return $couponsChartModel->addPoint($coupon['day'], $coupon['count']);
            }, (new AreaChartModel())
                ->setTitle('Cupones canjeados')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            $amount = 0.00;
            $amountChartModel = $coupons->reduce(function (AreaChartModel $amountChartModel, $data, $key) use($coupons, &$amount) {
                $coupon = $coupons[$key];
                $amount += $coupon['amount'];
                return $amountChartModel->addPoint($coupon['day'], round($amount));
            }, (new AreaChartModel())
                ->setTitle('Dinero canjeado')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
                ->setColor('#CF0924')
            );
            return view('livewire.reports.coupons.redeemed')->with(['couponsChartModel' => $couponsChartModel, 'amountChartModel' => $amountChartModel]);
        }

        return view('livewire.reports.coupons.redeemed');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getRedeemedCoupons($filters);
    }

    public function exportReport()
    {
        return (new RedeemedCouponsExport(collect($this->result['coupons'])))->download('reporte_cupones_canjeados.xlsx');
    }
}
