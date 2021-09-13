<?php

namespace App\Http\Livewire\Reports\Users;

use App\Exports\UsersHistoryExport;
use App\Http\Livewire\Reports\BaseUsersReport;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;

class NewUsers extends BaseUsersReport
{
    public $reportName = 'reports.users.new-users';
    protected $listeners = ['generateReport'];

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
        $this->result = $this->getNewUsers($filters);
    }

    public function exportReport()
    {
        //return (new UsersHistoryExport(collect($this->result['REGISTROS'])))->download('reporte_historico_usuarios.xlsx');
    }
}
