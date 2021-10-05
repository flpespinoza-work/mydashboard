<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\RedeemedCouponsExport;
use App\Http\Livewire\Reports\BaseCouponsReport;
use Asantibanez\LivewireCharts\Models\AreaChartModel;
use Maatwebsite\Excel\Facades\Excel;

class Redeemed extends BaseCouponsReport
{
    public $reportName = 'reports.coupons.redeemed';
    public $report_data;
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
                $day = __(date('D', strtotime(str_replace('/', '-',$coupon['day']))));
                return $couponsChartModel->addPoint($day . ' - ' . $coupon['day'], $coupon['count']);
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
                $day = __(date('D', strtotime(str_replace('/', '-',$coupon['day']))));
                return $amountChartModel->addPoint($day . ' - ' . $coupon['day'], round($amount));
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
        $this->report_data['store'] = fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getRedeemedCoupons($filters);
    }

}
