<?php

namespace App\Http\Livewire\Permission;

use App\Models\Permission;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['toggleUserPermission'];
    public $search = '';
    public $showModal = false;
    public $permission;

    protected $rules = [
        'permission.name' => 'required|unique:permissions,name',
        'permission.description' => 'required|string'
    ];

    public function render()
    {
        $users = User::search($this->search)->orderBy('id')->get();
        $permissions = Permission::orderBy('id')->get();
        $userPermissions = User::with('permissions')->get()->pluck('permissions', 'id')->toArray();
        return view('livewire.permission.index', compact('users', 'permissions', 'userPermissions'));
    }

    public function toggleUserPermission($user, $permission, $checked)
    {
        $u = User::findOrFail($user);
        if($checked)
        {
            $u->permissions()->attach($permission);
        }
        else
        {
            $u->permissions()->detach($permission);
        }
    }

    public function createPermission()
    {
        $this->permission = Permission::make();
        $this->showModal = true;
    }

    public function savePermission()
    {
        $this->validate();
        $this->permission->save();
        $this->showModal = false;
    }
}
