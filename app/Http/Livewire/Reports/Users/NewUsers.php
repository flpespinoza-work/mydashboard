<?php

namespace App\Http\Livewire\Reports\Users;

use App\Exports\UsersHistoryExport;
use App\Http\Livewire\Reports\BaseUsersReport;

class NewUsers extends BaseUsersReport
{
    public $reportName = 'reports.users.new-users';
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.users.new-users');
    }

    public function generateReport($filters)
    {
        $this->result = $this->getNewUsers($filters);
    }

    public function exportReport()
    {
        return (new UsersHistoryExport(collect($this->result['REGISTROS'])))->download('reporte_historico_usuarios.xlsx');
    }
}
