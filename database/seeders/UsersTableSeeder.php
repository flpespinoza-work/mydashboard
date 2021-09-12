<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@tokencash.mx',
            'password' => Hash::make('password'),
            'phone_number' => 3333333330,
            'group_id' => 1
        ]);

        $role = Role::find(1);
        $user->assignRole($role);

        /*
        $user = User::create([
            'name' => 'administrador de grupo',
            'email' => 'groupadmin@tokencash.mx',
            'password' => Hash::make('password'),
            'phone_number' => 3333333331,
            'group_id' => 2
        ]);

        $role = Role::find(2);
        $user->assignRole($role);


        $user = User::create([
            'name' => 'gerente',
            'email' => 'gerente@tokencash.mx',
            'password' => Hash::make('password'),
            'phone_number' => 3333333332,
            'group_id' => 3
        ]);

        $role = Role::find(2);
        $user->assignRole($role);
        */
    }
}

