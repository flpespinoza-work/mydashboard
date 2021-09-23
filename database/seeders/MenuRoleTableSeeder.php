<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRoleTableSeeder extends Seeder
{

    public function run()
    {
        //Obtener numero de items de menu registrados
        $menuItems = DB::table('menus')->get('id');
        $role = 1;
        foreach($menuItems as $menu)
        {
            $menu_role = ['menu_id' => $menu->id, 'role_id' => $role];
            DB::table('menu_role')->insert($menu_role);
        }

    }
}
