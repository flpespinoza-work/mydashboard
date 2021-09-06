<?php

namespace App\Http\Livewire\Group;

use Livewire\Component;
use App\Models\Group;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Group $group;
    public $showModal = false;

    public function mount()
    {
        $this->group = $this->initializeGroup();
    }

    public function initializeGroup()
    {
        return Group::make();;
    }

    public function render()
    {
        $groups = Group::with('stores')->get();
        return view('livewire.group.index', compact('groups'));
    }
}
