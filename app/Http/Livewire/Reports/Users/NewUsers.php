<?php

namespace App\Http\Livewire\Reports\Users;

use App\Http\Livewire\Reports\BaseUsersReport;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class NewUsers extends BaseUsersReport
{
    public $reportName = 'reports.users.new-users';
    public $report_data;
    protected $listeners = ['generateReport'];

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $usersChartModel = null;

            $users = collect($this->result['data']);

            $usersChartModel = $users->reduce(function (ColumnChartModel $usersChartModel, $data, $key) {
                $day = __(date('D', strtotime(str_replace('/', '-',$data['day']))));
                return $usersChartModel->addColumn( $day . ' - '. $data['day'], $data['users'], '#EF6A37');

            }, (new ColumnChartModel())
                ->setTitle('Nuevos usuarios')
                ->setAnimated(true)
                ->withoutLegend()
                ->withGrid()
                ->setXAxisVisible(true)
            );

            return view('livewire.reports.users.new-users')->with(['usersChartModel' => $usersChartModel]);
        }

        return view('livewire.reports.users.new-users');
    }

    public function generateReport($filters)
    {
        $this->report_data['store'] = fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getNewUsers($filters);
    }

}
