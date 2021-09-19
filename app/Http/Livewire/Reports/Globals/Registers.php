<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseGlobalsReport;
use App\Traits\Reports\Globals;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Registers extends BaseGlobalsReport
{
    use Globals;

    public $reportName = 'reports.globals.registers';
    public $store_name;
    protected $listeners = ['generateReport'];
    public $result = null;

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $usersChartModel = null;
            if(count($this->result['registers']) > 1)
            {
                $users = collect($this->result['totals']);
                $usersChartModel = $users->reduce(function (ColumnChartModel $usersChartModel, $users, $key) {
                    return $usersChartModel->addColumn($key, $users, '#5CB7DA');
                }, (new ColumnChartModel())
                    ->setTitle('Altas diarias')
                    ->withoutLegend()
                    ->setAnimated(true)
                    ->withGrid()
                    ->setXAxisVisible(true)
                );
            }
            else
            {
                $users = collect($this->result['registers'][$this->store_name]);
                $usersChartModel = $users->reduce(function (ColumnChartModel $usersChartModel, $users, $key) {
                    return $usersChartModel->addColumn($key, $users, '#5CB7DA');
                }, (new ColumnChartModel())
                    ->setTitle('Altas diarias')
                    ->withoutLegend()
                    ->setAnimated(true)
                    ->withGrid()
                    ->setXAxisVisible(true)
                );
            }

            return view('livewire.reports.globals.registers')->with(['usersChartModel' => $usersChartModel]);
        }

        return view('livewire.reports.globals.registers');
    }

    public function generateReport($filters)
    {
        $this->store_name = ($filters['store'] == 'all') ? 'Todos los establecimientos' : fnGetStoreName($filters['store']);
        $this->result = $this->getRegisters($filters);
    }
}
