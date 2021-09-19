<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Exports\GlobalsRedeemsExport;
use App\Http\Livewire\Reports\BaseGlobalsReport;
use App\Traits\Reports\Globals;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Redeems extends BaseGlobalsReport
{
    use Globals;
    public $reportName = 'reports.globals.redeems';
    public $report_data;
    protected $listeners = ['generateReport'];
    public $result = null;

    public function render()
    {

        if(!is_null($this->result) && !empty($this->result))
        {
            $redeemsChartModel = null;
            if(count($this->result['redeems']) > 1)
            {
                $redeems = collect($this->result['totals']);
                $redeemsChartModel = $redeems->reduce(function (ColumnChartModel $redeemsChartModel, $redeems, $key) {
                    return $redeemsChartModel->addColumn($key, $redeems, '#5CB7DA');
                }, (new ColumnChartModel())
                    ->setTitle('Canjes diarios')
                    ->setAnimated(true)
                    ->withoutLegend()
                    ->withGrid()
                    ->setXAxisVisible(true)
                );
            }
            else
            {
                $redeems = collect($this->result['redeems'][$this->report_data['store']]);
                $redeemsChartModel = $redeems->reduce(function (ColumnChartModel $redeemsChartModel, $redeems, $key) {
                    return $redeemsChartModel->addColumn($key, $redeems, '#5CB7DA');
                }, (new ColumnChartModel())
                    ->setTitle('Canjes diarios')
                    ->setAnimated(true)
                    ->withoutLegend()
                    ->withGrid()
                    ->setXAxisVisible(true)
                );
            }

            return view('livewire.reports.globals.redeems')->with(['redeemsChartModel' => $redeemsChartModel]);
        }

        return view('livewire.reports.globals.redeems');
    }

    public function generateReport($filters)
    {
        $this->report_data['store'] = ($filters['store'] == 'all') ? 'Todos mis establecimientos' : fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getRedeems($filters);
    }

    public function exportReport()
    {
        return (new GlobalsRedeemsExport($this->result['days'], collect($this->result['redeems']), $this->report_data))->download('reporte_global_canjes_diarios.xlsx');
    }
}
