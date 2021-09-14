<?php

namespace App\Http\Livewire\Reports\Users;

use App\Exports\UsersExport;
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
        //dd($this->result);
    }

    public function exportReport()
    {
        //return (new UsersExport(collect($this->result['REGISTROS'])))->download('reporte_nuevos_usuarios.xlsx');
    }
}
