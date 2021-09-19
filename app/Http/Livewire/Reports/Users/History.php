<?php

namespace App\Http\Livewire\Reports\Users;

use App\Exports\UsersHistoryExport;
use App\Http\Livewire\Reports\BaseUsersReport;

class History extends BaseUsersReport
{
    public $reportName = 'reports.users.history';
    public $store_name;
    protected $listeners = ['generateReport'];

    public function render()
    {
        return view('livewire.reports.users.history');
    }

    public function generateReport($filters)
    {
        $this->store_name = fnGetStoreNAme($filters['store']);
        $this->result = $this->getHistoryUsers($filters);
    }

    public function exportReport()
    {
        return (new UsersHistoryExport(collect($this->result['data']), $this->store_name))->download('reporte_acumulado_usuarios.xlsx');
    }
}
