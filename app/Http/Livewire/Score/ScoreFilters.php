<?php

namespace App\Http\Livewire\Score;

use Livewire\Component;
use App\Models\Store;

class ScoreFilters extends Component
{
    public $stores;
    public $sellers;
    public $initial_date;
    public $final_date;
    public $store;
    public $seller;

    public function mount()
    {
        $this->initial_date = date('Y-m-d');
        $this->final_date = date('Y-m-d');
        $this->stores = fnGetMyStores();
        $this->sellers = collect();
    }

    public function render()
    {
        return view('livewire.score.score-filters');
    }

    public function updatedStore($store)
    {
        if(!is_null($store))
        {
            $this->sellers = fnGetSellers($store);
        }
    }

    public function sendFiltersToReport()
    {
        unset($filters);
        $filters = [
            'store' => $this->store,
            'initial_date' => $this->initial_date,
            'final_date' => $this->final_date,
            'seller' => $this->seller
        ];

        $this->emitTo('score.index', 'getScore', $filters);
        //$this->reset();
    }
}
