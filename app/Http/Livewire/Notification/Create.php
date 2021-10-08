<?php

namespace App\Http\Livewire\Notification;

use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $selectedStore = null;
    public $showStores = false;
    public $filters = [];
    public $file;

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

        return view('livewire.notification.create', compact('stores'));
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
