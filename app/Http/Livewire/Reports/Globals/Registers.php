<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseGlobalsReport;
use App\Traits\Reports\Globals;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Registers extends BaseGlobalsReport
{
    use Globals;

    public $reportName = 'reports.globals.registers';
    public $store_name;
    protected $listeners = ['generateReport'];
    public $result = null;
    protected $selectedStore;

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $usersChartModel = null;
            $users = collect($this->result['registers'][$this->selectedStore]);
            $usersChartModel = $users->reduce(function (AreaChartModel $usersChartModel, $users, $key) {
                return $usersChartModel->addPoint($key, $users);
            }, (new AreaChartModel())
                ->setTitle('Altas diarias')
                ->setAnimated(true)
                ->setSmoothCurve()
                ->withGrid()
                ->setXAxisVisible(true)
            );
            return view('livewire.reports.globals.registers')->with(['usersChartModel' => $usersChartModel]);
        }

        return view('livewire.reports.globals.registers');
    }

    public function generateReport($filters)
    {
        $this->store_name = ($filters['store'] == 'all') ? 'Todos los establecimientos' : fnGetStoreName($filters['store']);
        $this->result = $this->getRegisters($filters);
        //dd($this->result);
    }
}
