<?php

namespace App\Http\Livewire\Reports\Globals;

use App\Exports\GlobalsRegistersExport;
use App\Http\Livewire\Reports\BaseGlobalsReport;
use App\Traits\Reports\Globals;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class Registers extends BaseGlobalsReport
{
    use Globals;

    public $reportName = 'reports.globals.registers';
    public $report_data;
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
                    $day = __(date('D', strtotime(str_replace('/', '-', $key))));
                    return $usersChartModel->addColumn($day . ' - ' . $key, $users, '#EF6A37');
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
                $users = collect($this->result['registers'][$this->report_data['store']]);
                $usersChartModel = $users->reduce(function (ColumnChartModel $usersChartModel, $users, $key) {
                    $day = __(date('D', strtotime(str_replace('/', '-', $key))));
                    return $usersChartModel->addColumn($day . ' - ' . $key, $users, '#EF6A37');
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
        $this->report_data['store'] = ($filters['store'] == 'all') ? 'Todos mis establecimientos' : fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getRegisters($filters);
    }

    public function exportReport()
    {
        return (new GlobalsRegistersExport($this->result['days'], collect($this->result['registers']), $this->report_data))->download('reporte_global_altas_diarias.xlsx');
    }
}
