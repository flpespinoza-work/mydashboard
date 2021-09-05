<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupTableSeeder extends Seeder
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
                'name' => 'Gasomax'
            ],
            [
                'name' => 'Shell'
            ],
            [
                'name' => 'Redpetroil'
            ],
        ];

        DB::table('groups')->insert($groups);
    }
}
