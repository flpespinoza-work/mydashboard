<?php

namespace App\Http\Livewire\Score;

use Livewire\Component;
use App\Models\Store;

class ScoreFilters extends Component
{
    protected $stores = [];
    public $sellers = [];
    public $initial_date;
    public $final_date;
    public $selectedStore;
    public $selectedSeller;

    public function mount()
    {
        $this->initial_date = date('Y-m-d');
        $this->final_date = date('Y-m-d');

    }

    public function render()
    {
        $this->stores = Store::orderBy('name')->pluck('name', 'id');
        return view('livewire.score.score-filters')->with(['stores' => $this->stores]);
    }

    public function updatedSelectedStore($store)
    {
        if(!is_null($store))
        {
            $this->sellers = fnGetSellers($store);
        }
    }

    public function sendFiltersToReport()
    {
        $filters = [
            'store' => $this->selectedStore,
            'initial_date' => $this->initial_date,
            'final_date' => $this->final_date,
            'seller' => $this->selectedSeller
        ];

        $this->emitTo('score.index', 'getScore', $filters);
        //$this->reset();
    }
}
