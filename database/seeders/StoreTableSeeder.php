<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayOfStores = [
            [
                'name' => 'todos los establecimientos',
            ],
            [
                'name' => 'todos '
            ]
        ];

        $stores = collect($arrayOfStores)->map(function($store){
            return [
                'name' => $store['name']
            ];
        });

        DB::table('stores')->insert($stores->toArray());
    }
}
