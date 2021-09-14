<?php

namespace App\Http\Livewire\Reports\Coupons;

use App\Exports\PrintedRedeemedCouponsExport;
use App\Http\Livewire\Reports\BaseCouponsReport;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class PrintedRedeemed extends BaseCouponsReport
{
    public $reportName = 'reports.coupons.printed-redeemed';
    public $store_name;
    protected $listeners = ['generateReport'];

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $couponsChartModel = null;
            $mount = 0.00;
            $coupons = collect($this->result['coupons']);
            $couponsChartModel = $coupons->reduce(function (LineChartModel $couponsChartModel, $data, $key) use(&$mount) {
                $couponsChartModel->addSeriesPoint('Cupones impresos', $key, $data['printed']);

                if(isset($data['redeemed']))
                {
                    $mount += $data['redeemed'];
                    $couponsChartModel->addSeriesPoint('Cupones canjeados', $key, $data['redeemed']);
                }
                else
                {
                    $couponsChartModel->addSeriesPoint('Cupones canjeados', $key, 0);
                }

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

            return view('livewire.reports.coupons.printed-redeemed')->with(['couponsChartModel' => $couponsChartModel]);
        }

        return view('livewire.reports.coupons.printed-redeemed');
    }

    public function generateReport($filters)
    {
        $this->store_name = fnGetStoreNAme($filters['store']);
        $this->result = $this->getPrintedRedeemedCoupons($filters);
    }

    public function exportReport()
    {
        return (new PrintedRedeemedCouponsExport(collect($this->result['coupons'])))->download('reporte_cupones_canjeados_impresos.xlsx');
    }
}
