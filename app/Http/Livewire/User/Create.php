<?php

namespace App\Http\Livewire\User;

use App\Models\Group;
use App\Models\Menu;
use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        try
        {
            $user = User::create([
                'name'         => $this->user['name'],
                'email'        => $this->user['email'],
                'phone_number' => $this->user['phone_number'],
                'password'     => Hash::make($this->user['password']),
                'home'         => $this->user['home'],
                'group_id'     => $this->group
            ]);

            $role = Role::findById($this->role);
            $user->assignRole($role);

            foreach($this->userStores as $store)
            {
                $s = Store::find($store);
                $user->stores()->save($s);
            }

            $user->save();

            $this->dispatchBrowserEvent('swal:success', [
                'type' => 'success',
                'message' => 'Se guardo el usuario correctamente'
            ]);

        }
        catch (\Throwable $th)
        {
            $this->dispatchBrowserEvent('swal:error', [
                'type' => 'error',
                'message' => 'Ocurrio un error al guardar el usuario, intente de nuevo'
            ]);
        }


    }
}
