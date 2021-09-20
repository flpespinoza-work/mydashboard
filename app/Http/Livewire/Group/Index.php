<?php

namespace App\Http\Livewire\Group;

use Livewire\Component;
use App\Models\Group;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    //public Group $group;
    public $group;
    public $showModal = false;
    public $search = '';

    protected $rules = [
        'group.name' => 'required|min:6|unique:groups,name',
        'group.contact' => 'min:5',
        'group.email' => 'email:rfc,dns',
        'group.phone' => 'digits:10'
    ];

    public function mount()
    {
        $this->group = $this->initializeGroup();
    }

    public function create()
    {
        if($this->group->getKey())
            $this->group = $this->initializeGroup();
        $this->showModal = true;
    }

    public function edit(Group $group)
    {
        if($this->group->isNot($group))
            $this->group = $group;
        $this->showModal = true;
    }

    public function initializeGroup()
    {
        return Group::make();;
    }

    public function render()
    {
        $groups = Group::search($this->search)
        ->with('stores')
        ->Paginate(20);

        return view('livewire.group.index', compact('groups'));
    }

    public function saveGroup()
    {
        $this->validate();
        $this->group->save();
        $this->showModal = false;
    }
}
