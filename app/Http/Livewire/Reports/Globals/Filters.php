<?php

namespace App\Http\Livewire\Reports\Globals;

use Livewire\Component;

class Filters extends Component
{
    public $report;

    protected $rules = [
        'filters.initial_date' => 'required',
        'filters.final_date' => 'required'
    ];

    public $filters = [
        'store' => null,
        'initial_date' => null,
        'final_date' => null
    ];

    public function mount($report)
    {
        $this->$report = $report;
        $this->filters['initial_date'] = date('Y-m-d');
        $this->filters['final_date'] = date('Y-m-d');
    }

    public function render()
    {
        $stores = fnGetMyStores();
        return view('livewire.reports.globals.filters', compact('stores'));
    }

    public function sendFiltersToReport()
    {
        $this->validate();
        $this->emitTo($this->report,'generateReport', $this->filters);
    }


}
