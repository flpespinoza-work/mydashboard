<?php

namespace App\Http\Livewire\Reports\Globals;

use Illuminate\Support\Arr;
use Livewire\Component;

class Filters extends Component
{
    public $report;
    public $hideStores = false;
    public $selectedStore = null;
    public $showStores = false;

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
        $stores = Arr::prepend($stores, 'TODOS LOS ESTABLECIMIENTOS', 'all');
        if(strlen($this->selectedStore) >= 3)
        {
            $search = $this->selectedStore;
            $stores = array_filter($stores, function($store) use($search) {
                return (stripos($store, $search) !== false);
            }, ARRAY_FILTER_USE_BOTH);
        }

        return view('livewire.reports.globals.filters', compact('stores'));
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

    public function sendFiltersToReport()
    {
        $this->validate();
        $this->emitTo($this->report,'generateReport', $this->filters);
    }


}
