<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'name' => 'Todos'
            ],
            [
                'name' => 'ATG'
            ],
            [
                'name' => 'Euro'
            ],
            [
                'name' => 'Hormadi'
            ],
            [
                'name' => 'Servicio El Milagro'
            ],
            [
                'name' => 'Guerra'
            ],
            [
                'name' => 'Petro'
            ],
            [
                'name' => 'ATH'
            ],
            [
                'name' => 'Gaxxor'
            ]
        ];

        DB::table('groups')->insert($groups);
    }
}
