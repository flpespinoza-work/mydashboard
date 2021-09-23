<?php

namespace App\Http\Livewire\User;

use App\Models\Group;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Store;
use Livewire\Component;

class Create extends Component
{
    public $user = [
        'name' => '',
        'email' => '',
        'password' => '',
        'phone_number' => '',
        'home' => ''
    ];

    protected $rules = [
        'user.name' => 'required|max:255',
        'user.email' => 'required|email:rfc',
        'user.password' => 'required|confirmed|min:8'
    ];

    public $group = null;
    public $role = null;

    public $userStores = [];

    public function render()
    {
        $roles = Role::all();
        $groups = Group::all();
        $modules = collect();
        $stores = collect();

        if(!is_null($this->role))
        {
            $modules = Menu::getMenuModules($this->role);
        }

        if(!is_null($this->group))
        {
            $stores = Store::getStoresByGroup($this->group);
        }


        return view('livewire.user.create', compact('roles', 'groups', 'modules', 'stores'));
    }

    public function createUser()
    {
        dd($this->user);
    }
}