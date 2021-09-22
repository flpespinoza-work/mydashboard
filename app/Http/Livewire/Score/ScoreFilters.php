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
    public $selectedStore = null;
    public $showStores = false;

    public function mount()
    {
        $this->initial_date = date('Y-m-d');
        $this->final_date = date('Y-m-d');
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

        return view('livewire.score.score-filters', compact('stores'));
    }

    public function getSellers($store)
    {
        $this->sellers = fnGetSellers($store);
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
    }

    public function selectStore($store, $name)
    {
        $this->selectedStore = $name;
        $this->store = $store;
        $this->showStores = false;
        $this->getSellers($this->store);
    }

    public function clearStore()
    {
        $this->selectedStore = null;
        $this->showStores = true;
        $this->store = null;

    }
}
