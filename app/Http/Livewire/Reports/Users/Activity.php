<?php

namespace App\Http\Livewire\Reports\Users;

use App\Traits\Reports\Users;
use Livewire\Component;
use Asantibanez\LivewireCharts\Models\LineChartModel;

class Activity extends Component
{
    use Users;

    public $reportName = 'reports.users.activity';
    public $report_data;
    public $result = null;
    protected $listeners = ['generateReport', 'exportReport'];

    public function render()
    {
        if(!is_null($this->result) && isset($this->result['redeems_day']))
        {
            $chartModel = null;
            $redeems = collect($this->result['redeems_day']);
            $sales = collect($this->result['sales_day']);
            $chartModel = $redeems->reduce(function (LineChartModel $chartModel, $data, $key) use ($sales) {
                $chartModel->addSeriesPoint('Canje', $key, $data);
                $chartModel->addSeriesPoint('Compra', $key, $sales[$key]);
                return $chartModel;
            }, (new LineChartModel())
                ->setTitle('Hábitos de canje y compra')
                ->multiLine()
                ->setAnimated(true)
                ->withGrid()
                ->setXAxisVisible(true)
                ->setColors(['#259FFB', '#EF6A37'])
            );

            return view('livewire.reports.users.activity')->with(['chartModel' => $chartModel]);
        }

        return view('livewire.reports.users.activity');
    }

    public function generateReport($filters)
    {
        $this->report_data['store'] = fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getUserActivity($filters);
        //dd($this->result);
    }

    public function exportReport()
    {

    }
}
