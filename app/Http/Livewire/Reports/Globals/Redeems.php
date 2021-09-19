<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseGlobalsReport;
use App\Traits\Reports\Globals;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Redeems extends BaseGlobalsReport
{
    use Globals;
    public $reportName = 'reports.globals.redeems';
    public $store_name;
    protected $listeners = ['generateReport'];
    public $result = null;
    private $selectedStore = null;

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
                $redeems = collect($this->result['redeems'][$this->store_name]);
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

    public function selectStoreChart($store)
    {
        //dd($store);
        $this->selectedStore = $store;
    }

    public function generateReport($filters)
    {
        $this->store_name = ($filters['store'] == 'all') ? 'Todos los establecimientos' : fnGetStoreName($filters['store']);
        $this->result = $this->getRedeems($filters);
        //dd($this->result);
    }
}
