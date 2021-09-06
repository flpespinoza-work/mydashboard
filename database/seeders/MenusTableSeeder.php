<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{

    public function run()
    {
        $groups = [
            [
                'menu_id' => null,
                'name' => 'Principal',
                'order' => 0,
                'icon' => null,
                'route' => null,
                'route-group' => null
            ],
            [
                'menu_id' => null,
                'name' => 'Reportes',
                'order' => 1,
                'icon' => null,
                'route' => null,
                'route-group' => null
            ],
            [
                'menu_id' => null,
                'name' => 'Administración',
                'order' => 2,
                'icon' => null,
                'route' => null,
                'route-group' => null
            ],
            [
                'menu_id' => 1,
                'name' => 'Dashboard',
                'order' => 0,
                'icon' => 'heroicon-s-view-grid',
                'route' => 'dashboard',
                'route-group' => null
            ],
            [
                'menu_id' => 1,
                'name' => 'Campañas',
                'order' => 1,
                'icon' => 'heroicon-s-bell',
                'route' => 'notifications',
                'route-group' => null
            ],
            [
                'menu_id' => 1,
                'name' => 'Calificaciones',
                'order' => 2,
                'icon' => 'heroicon-s-star',
                'route' => 'scores',
                'route-group' => null
            ],
            [
                'menu_id' => 2, //7
                'name' => 'Usuarios',
                'order' => 0,
                'icon' => 'heroicon-s-users',
                'route' => null,
                'route-group' => 'reports.users'
            ],
            [
                'menu_id' => 2,
                'name' => 'Cupones', //8
                'order' => 1,
                'icon' => 'heroicon-s-tag',
                'route' => null,
                'route-group' => 'reports.coupons'
            ],
            [
                'menu_id' => 2,
                'name' => 'Ventas', //9
                'order' => 2,
                'icon' => 'heroicon-s-currency-dollar',
                'route' => null,
                'route-group' => 'reports.sales'
            ],
            [
                'menu_id' => 2,
                'name' => 'Globales', //10
                'order' => 3,
                'icon' => 'heroicon-s-globe',
                'route' => null,
                'route-group' => 'reports.globals'
            ],
            [
                'menu_id' => 2,
                'name' => 'Saldo disponible', //11
                'order' => 4,
                'icon' => 'heroicon-s-credit-card',
                'route' => 'reports.balance',
                'route-group' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Usuarios',
                'order' => 0,
                'icon' => 'heroicon-s-user-circle',
                'route' => 'users.index',
                'route-group' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Roles',
                'order' => 1,
                'icon' => 'heroicon-s-identification',
                'route' => 'roles.index',
                'route-group' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Permisos',
                'order' => 2,
                'icon' => 'heroicon-s-lock-closed',
                'route' => 'permissions.index',
                'route-group' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Grupos',
                'order' => 3,
                'icon' => 'heroicon-s-office-building',
                'route' => 'groups.index',
                'route-group' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Establecimientos',
                'order' => 4,
                'icon' => 'heroicon-s-home',
                'route' => 'stores.index',
                'route-group' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Menús',
                'order' => 5,
                'icon' => 'heroicon-s-menu-alt-2',
                'route' => null,
                'route-group' => null
            ],
            [
                'menu_id' => 3,
                'name' => 'Respuestas',
                'order' => 6,
                'icon' => 'heroicon-s-chat-alt',
                'route' => 'response.index',
                'route-group' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'Nuevos usuarios',
                'order' => 0,
                'icon' => null,
                'route' => 'reports.users.new',
                'route-group' => null
            ],
            [
                'menu_id' => 7,
                'name' => 'Acumulado',
                'order' => 1,
                'icon' => null,
                'route' => 'reports.users.history',
                'route-group' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'Impresos',
                'order' => 0,
                'icon' => null,
                'route' => 'reports.coupons.printed',
                'route-group' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'Canjeados',
                'order' => 1,
                'icon' => null,
                'route' => 'reports.coupons.redeemed',
                'route-group' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'Detallado de cupones canjeados',
                'order' => 2,
                'icon' => null,
                'route' => 'reports.coupons.detail-redeemed',
                'route-group' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'Último cupón',
                'order' => 3,
                'icon' => null,
                'route' => 'reports.coupons.last-printed',
                'route-group' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'Impresos vs Canjeados',
                'order' => 4,
                'icon' => null,
                'route' => 'reports.coupons.printed-redeemed',
                'route-group' => null
            ],
            [
                'menu_id' => 8,
                'name' => 'Acumulado canjeados e impresos',
                'order' => 5,
                'icon' => null,
                'route' => 'reports.coupons.printed-redeemed-history',
                'route-group' => null
            ],
            [
                'menu_id' => 9,
                'name' => 'Detallado',
                'order' => 0,
                'icon' => null,
                'route' => 'reports.sales.detail',
                'route-group' => null
            ],
            [
                'menu_id' => 9,
                'name' => 'Acumulado',
                'order' => 1,
                'icon' => null,
                'route' => 'reports.sales.history',
                'route-group' => null
            ],
            [
                'menu_id' => 9,
                'name' => 'Ventas realizadas',
                'order' => 2,
                'icon' => null,
                'route' => 'reports.sales.sales',
                'route-group' => null
            ],
            [
                'menu_id' => 10,
                'name' => 'Canjes diarios',
                'order' => 0,
                'icon' => null,
                'route' => 'reports.globals.redeems',
                'route-group' => null
            ],
            [
                'menu_id' => 10,
                'name' => 'Altas diarias',
                'order' => 1,
                'icon' => null,
                'route' => 'reports.globals.registers',
                'route-group' => null
            ],
        ];

        DB::table('menus')->insert($groups);
    }
}
