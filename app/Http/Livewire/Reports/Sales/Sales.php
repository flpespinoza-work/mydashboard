<?php

namespace App\Http\Livewire\Reports\Sales;

use App\Exports\SalesExport;
use App\Http\Livewire\Reports\BaseSalesReport;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Sales extends BaseSalesReport
{
    public $reportName = 'reports.sales.sales';
    public $report_data;
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
                $day = __(date('D', strtotime(str_replace('/', '-', $coupon['date']))));
                return $couponsChartModel->addPoint($day . ' - ' . $coupon['date'], $coupon['sales']);
            }, (new AreaChartModel())
                ->setTitle('Ventas realizadas')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
                ->setColor('#EF6A37')
            );

            return view('livewire.reports.sales.sales')->with(['salesChartModel' => $couponsChartModel]);
        }

        return view('livewire.reports.sales.sales');
    }

    public function generateReport($filters)
    {
        $this->report_data['store'] = fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getSales($filters);
    }

    public function exportReport()
    {
        return (new SalesExport(collect($this->result['sales']), $this->report_data))->download('reporte_ventas.xlsx');
    }
}
