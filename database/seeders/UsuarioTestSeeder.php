<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grupo = Group::where('name', 'Hormadi')->first()->id;
        $role = Role::where('name', 'groupadmin')->first()->id;

        $user = User::create([
            'name' => 'Carlos',
            'email' => 'supervision.bombas@grupohormadi.com',
            'password' => Hash::make('xWeHjdU9'),
            'phone_number' => '',
            'group_id' => $grupo
        ]);
        $user->assignRole($role);

        //Menus
        $menus = DB::table('menus')->whereRaw('(id != 35 AND id != 69 AND id != 171) AND (menu_id != 35 OR menu_id IS NULL)')->get();
        foreach($menus as $menu)
        {
            $menu_role = ['menu_id' => $menu->id, 'role_id' => $role];
            DB::table('menu_role')->insert($menu_role);
        }

    }
}
