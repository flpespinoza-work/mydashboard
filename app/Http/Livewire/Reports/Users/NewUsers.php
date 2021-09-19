<?php

namespace App\Http\Livewire\Reports\Users;

use App\Exports\UsersExport;
use App\Http\Livewire\Reports\BaseUsersReport;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class NewUsers extends BaseUsersReport
{
    public $reportName = 'reports.users.new-users';
    public $report_data;
    protected $listeners = ['generateReport', 'exportReport'];

    public function render()
    {
        if(!is_null($this->result) && !empty($this->result))
        {
            $usersChartModel = null;

            $users = collect($this->result['data']);

            $usersChartModel = $users->reduce(function (ColumnChartModel $usersChartModel, $data, $key) {
                return $usersChartModel->addColumn($data['day'], $data['users'], '#5CB7DA');

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

    public function exportReport()
    {
        return (new UsersExport(collect($this->result['data']), $this->report_data))->download('reporte_nuevos_usuarios.xlsx');
    }
}
