<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\PrintedCouponsExport;
use App\Http\Livewire\Reports\BaseCouponsReport;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Printed extends BaseCouponsReport
{
    public $reportName = 'reports.coupons.printed';
    public $report_data;
    protected $listeners = ['generateReport'];

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $couponsChartModel = null;
            $amountChartModel = null;

            $coupons = collect($this->result['coupons']);

            $couponsChartModel = $coupons->reduce(function (AreaChartModel $couponsChartModel, $data, $key) {
                $day = __(date('D', strtotime(str_replace('/', '-', $key))));
                return $couponsChartModel->addPoint($day . ' - ' . $key, $data['count']);
            }, (new AreaChartModel())
                ->setTitle('Cupones impresos')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            $amountChartModel = $coupons->reduce(function (AreaChartModel $amountChartModel, $data, $key) {
                $day = __(date('D', strtotime(str_replace('/', '-', $key))));
                return $amountChartModel->addPoint($day . ' - ' . $key, round($data['aggr']));
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
        $this->report_data['store'] = fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getPrintedCoupons($filters);
    }

}
