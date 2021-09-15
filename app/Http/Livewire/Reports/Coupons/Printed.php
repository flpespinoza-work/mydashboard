<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\PrintedCouponsExport;
use App\Http\Livewire\Reports\BaseCouponsReport;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Printed extends BaseCouponsReport
{
    public $reportName = 'reports.coupons.printed';
    public $store_name;
    protected $listeners = ['generateReport'];

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $couponsChartModel = null;
            $amountChartModel = null;

            $coupons = collect($this->result['coupons']);

            $couponsChartModel = $coupons->reduce(function (AreaChartModel $couponsChartModel, $data, $key) {
                return $couponsChartModel
                ->addPoint($key, $data['count']);
            }, (new AreaChartModel())
                ->setTitle('Cupones impresos')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            $amountChartModel = $coupons->reduce(function (AreaChartModel $amountChartModel, $data, $key) {
                return $amountChartModel->addPoint($key, round($data['aggr']));
            }, (new AreaChartModel())
                ->setTitle('Dinero impreso')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
                ->setColor('#CF0924')
            );
            return view('livewire.reports.coupons.printed')->with(['couponsChartModel' => $couponsChartModel, 'amountChartModel' => $amountChartModel]);
        }

        return view('livewire.reports.coupons.printed');
    }

    public function generateReport($filters)
    {
        $this->store_name = fnGetStoreNAme($filters['store']);
        $this->result = $this->getPrintedCoupons($filters);
    }

    public function exportReport()
    {
        return (new PrintedCouponsExport(collect($this->result['coupons'])))->download('reporte_cupones_impresos.xlsx');
    }
}
