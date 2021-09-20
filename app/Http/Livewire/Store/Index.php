<?php

namespace App\Http\Livewire\Store;

use App\Models\Store;
use App\Models\Group;
use Livewire\Component;

class Index extends Component
{
    public $groups;
    public $store, $group;
    public $showModal = false;

    protected $rules = [
        'store.name' => 'required',
        'store.node' => 'required|unique:stores,node',
        'store.giftcard' => 'required|unique:stores,giftcard',
        'store.budget' => 'required|unique:stores,budget',
        'store.email' => 'email:rfc',
        'store.phone' => 'digits:10'
    ];

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

    public function saveStore()
    {
        $this->validate();

        //Asignar grupo
        $this->store->group_id = $this->group;
        $this->store->save();
        $this->showModal = false;
    }
}
