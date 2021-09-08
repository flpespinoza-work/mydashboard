<?php

namespace App\Http\Livewire\Reports;

use App\Models\Store;
use Livewire\Component;

class Filters extends Component
{
    public $report;

    protected $rules = [
        'filters.store' => 'required',
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
        $this->report = $report;
        $this->filters['initial_date'] = date('Y-m-d');
        $this->filters['final_date'] = date('Y-m-d');
    }

    public function render()
    {
        $stores = Store::orderBy('name')->pluck('name', 'id');
        return view('livewire.reports.filters', compact('stores'));
    }

    public function sendFiltersToReport()
    {
        $this->validate();

        $this->emitTo($this->report,'generateReport', $this->filters);
    }
}
