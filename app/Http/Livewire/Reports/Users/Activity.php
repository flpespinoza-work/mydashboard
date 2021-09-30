<?php

namespace App\Http\Livewire\Reports\Users;

use App\Traits\Reports\Users;
use Livewire\Component;

class Activity extends Component
{
    use Users;

    public $reportName = 'reports.users.activity';
    public $report_data;
    public $result = null;
    protected $listeners = ['generateReport', 'exportReport'];

    public function render()
    {
        if(count($this->result['redeems_day']))
        {

        }

        return view('livewire.reports.users.activity');
    }

    public function generateReport($filters)
    {
        $this->report_data['store'] = fnGetStoreName($filters['store']);
        $this->report_data['period'] = "Periodo: " . date('d/m/Y', strtotime($filters['initial_date'])) ." al " . date('d/m/Y', strtotime($filters['final_date']));
        $this->result = $this->getUserActivity($filters);
        dd($this->result);
    }

    public function exportReport()
    {

    }
}
