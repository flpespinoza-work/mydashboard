<?php

namespace App\Http\Livewire\Store;

use App\Models\Store;
use App\Models\Group;
use Livewire\Component;

class Index extends Component
{
    public $groups;
    //public Store $store;
    public $store;
    public $showModal = false;

    public function mount()
    {
        $this->store = $this->initializeStore();
        $this->groups = Group::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.store.index');
    }

    public function create()
    {
        if($this->store->getKey())
            $this->store = $this->initializeStore();
        $this->showModal = true;
    }

    public function initializeStore()
    {
        return Store::make();
    }
}
