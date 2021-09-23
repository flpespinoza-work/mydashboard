<?php

namespace App\Http\Livewire\Role;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $showModal = false;
    public $role;

    protected $rules = [
        'role.name' => 'required|unique:roles,name',
        'role.description' => 'max:50',
    ];

    public function mount()
    {
        $this->role = $this->initializeRole();
    }

    public function render()
    {
        $roles = Role::with(['permissions'])->paginate();
        return view('livewire.role.index', compact('roles'));
    }

    public function initializeRole()
    {
        return Role::make();
    }

    public function create()
    {
        if($this->role->getKey())
            $this->role = $this->initializeRole();
        $this->showModal = true;
    }

    public function saveRole()
    {
        $this->validate();

        //Asignar grupo
        $this->role->save();
        $this->showModal = false;
    }
}
