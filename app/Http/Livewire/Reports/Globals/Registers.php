<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Http\Livewire\Reports\BaseGlobalsReport;
use App\Traits\Reports\Globals;
use Asantibanez\LivewireCharts\Models\AreaChartModel;

class Registers extends BaseGlobalsReport
{
    use Globals;

    public $reportName = 'reports.globals.registers';
    protected $listeners = ['generateReport'];
    public $result = null;

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $usersChartModel = null;

            $users = collect($this->result['registers']);

            $usersChartModel = $users->reduce(function (AreaChartModel $usersChartModel, $data, $key) {
                return $usersChartModel->addPoint($data['day'], $data['users']);
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
        $this->result = $this->getRegisters($filters);
    }
}
