<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseGlobalsReport;
use App\Traits\Reports\Globals;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Redeems extends BaseGlobalsReport
{
    use Globals;
    public $reportName = 'reports.globals.redeems';
    protected $listeners = ['generateReport'];
    public $result = null;

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $redeemsChartModel = null;
            $users = collect($this->result['redeems']);

            $redeemsChartModel = $users->reduce(function (ColumnChartModel $redeemsChartModel, $data, $key) {
                return $redeemsChartModel->addColumn($data['day'], $data['redeems'], '#5CB7DA');

            }, (new ColumnChartModel())
                ->setTitle('Canjes diarios')
                ->setAnimated(true)
                ->withoutLegend()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            return view('livewire.reports.globals.redeems')->with(['redeemsChartModel' => $redeemsChartModel]);
        }

        return view('livewire.reports.globals.redeems');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getRedeems($filters);
    }
}
