<?php

namespace App\Http\Livewire\Score;

use Livewire\Component;
use App\Models\Store;

class ScoreFilters extends Component
{
    public $sellers;
    public $initial_date;
    public $final_date;
    public $store;
    public $seller;

    public function mount()
    {
        $this->initial_date = date('Y-m-d');
        $this->final_date = date('Y-m-d');
    }

    public function render()
    {
        $stores = fnGetMyStores();
        return view('livewire.score.score-filters', compact('stores'));
    }

    public function updatedStore($store)
    {
        if(!is_null($store))
        {
            $this->sellers = fnGetSellers($store);
        }
    }

    public function selectSeller($seller)
    {
        $this->seller = $seller;
    }

    public function sendFiltersToReport()
    {
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
