<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Obtener numero de items de menu registrados
        $menuItems = DB::table('menus')->count('id');
        for($i = 1; $i <= 3; $i++)
        {
            for($x=1; $x<=$menuItems; $x++)
            {
                if($i == 1)
                {
                    $menu_role = ['menu_id' => $x, 'role_id' => $i];
                    DB::table('menu_role')->insert($menu_role);
                }
                else
                {
                    $add = random_int(0,1);
                    if($add)
                    {
                        $menu_role = ['menu_id' => $x, 'role_id' => $i];
                        DB::table('menu_role')->insert($menu_role);
                    }
                }
            }
        }

    }
}
