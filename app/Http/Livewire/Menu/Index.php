<?php

namespace App\Http\Livewire\Menu;

use Livewire\Component;
use App\Models\Menu;
use App\Models\Role;

class Index extends Component
{
    protected $listeners = ['toggleMenuRole'];
    public $selectedSection = null;
    public $showModal = false;
    public $menu;
    public $type;

    protected $rules = [
        'menu.name'        => 'required',
        'menu.order'       => 'numeric',
        'menu.route-group' => 'string',
        'menu.description' => 'string',
        'menu.route'       => 'string',
        'menu.icon'        => 'string|starts_with:heroicon',
        'menu.menu_id'     => 'numeric'
    ];

    public function render()
    {
        $roles = Role::orderBy('id')->get();
        $menus = Menu::getMenu();
        $menuRoles = Menu::with('roles')->get()->pluck('roles', 'id')->toArray();
        $menuSection = Menu::whereNull('menu_id')->pluck('name', 'id')->toArray();
        $menuGroup = collect();

        if(!is_null($this->selectedSection))
        {
            $menuGroup = Menu::where('menu_id', $this->selectedSection)->whereNull('route')->pluck('name', 'id');
        }

        return view('livewire.menu.index', compact('roles', 'menus', 'menuRoles', 'menuSection', 'menuGroup'));
    }

    public function toggleMenuRole($role, $menu, $checked)
    {
        $m = Menu::findOrFail($menu);
        if($checked)
        {
            $m->roles()->attach($role);
        }
        else
        {
            $m->roles()->detach($role);
        }

        cache()->tags('Menu')->forget("MenuSidebar.roleid.$role");
    }

    public function createMenu($type)
    {
        $this->menu = Menu::make();
        $this->type = $type;
        $this->showModal = true;
    }

    public function saveMenu($type)
    {
        //Si es un grupo asignar el valor de la seccion
        if($type == 'group')
            $this->menu->menu_id = $this->selectedSection;

        $this->validate();

        $this->menu->save();
        $this->showModal = false;
    }

}
