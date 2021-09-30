<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;

class FiltersActivity extends Component
{
    public $report;
    public $selectedStore = null;
    public $showStores = false;

    protected $rules = [
        'filters.store' => 'required',
        'filters.user' => 'required|numeric',
        'filters.initial_date' => 'required',
        'filters.final_date' => 'required'
    ];

    public $filters = [
        'store' => null,
        'user' => null,
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
        $stores = fnGetMyStores();

        if(strlen($this->selectedStore) >= 3)
        {
            $search = $this->selectedStore;
            $stores = array_filter($stores, function($store) use($search) {
                return (stripos($store, $search) !== false);
            }, ARRAY_FILTER_USE_BOTH);
        }

        return view('livewire.reports.filters-activity', compact('stores'));
    }

    public function sendFiltersToReport()
    {
        $this->validate();
        $this->emitTo($this->report,'generateReport', $this->filters);
    }

    public function selectStore($store, $name)
    {
        $this->selectedStore = $name;
        $this->filters['store'] = $store;
        $this->showStores = false;
    }

    public function clearStore()
    {
        $this->selectedStore = null;
        $this->showStores = true;
        $this->filters['store'] = null;
    }
}








