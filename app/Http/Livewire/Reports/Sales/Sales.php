<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Http\Livewire\Reports\BaseSalesReport;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Sales extends BaseSalesReport
{
    public $reportName = 'reports.sales.sales';
    protected $listeners = ['generateReport'];

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            //dd($this->result);
            $couponsChartModel = null;

            $coupons = collect($this->result['sales']);

            $couponsChartModel = $coupons->reduce(function (AreaChartModel $couponsChartModel, $data, $key) use($coupons) {
                $coupon = $coupons[$key];
                return $couponsChartModel->addPoint($key, $coupon['sales']);
            }, (new AreaChartModel())
                ->setTitle('Ventas realizadas')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            return view('livewire.reports.sales.sales')->with(['salesChartModel' => $couponsChartModel]);
        }

        return view('livewire.reports.sales.sales');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getSales($filters);
        //dd($this->result);
    }
}
