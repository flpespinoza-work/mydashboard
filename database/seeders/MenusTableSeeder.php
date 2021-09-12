<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{

    public function run()
    {
        //Crear titulos de secciones
        $titles = [
            [
                'menu_id' => null,
                'name' => 'Principal',
                'order' => 0,
                'icon' => null,
                'route' => null,
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => null,
                'name' => 'Reportes',
                'order' => 1,
                'icon' => null,
                'route' => null,
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => null,
                'name' => 'Administración',
                'order' => 2,
                'icon' => null,
                'route' => null,
                'route-group' => null,
                'active' => true
            ]
        ];
        DB::table('menus')->insert($titles);

        //Crear grupos principales
        $principal = DB::table('menus')->where('name', 'Principal')->first()->id;
        $reportes = DB::table('menus')->where('name', 'Reportes')->first()->id;
        $admin = DB::table('menus')->where('name', 'Administración')->first()->id;
        $groups = [
            [
                'menu_id' => $principal,
                'name' => 'Dashboard',
                'order' => 0,
                'icon' => 'heroicon-s-view-grid',
                'route' => 'dashboard',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $principal,
                'name' => 'Campañas',
                'order' => 1,
                'icon' => 'heroicon-s-bell',
                'route' => 'notifications',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $principal,
                'name' => 'Calificaciones',
                'order' => 2,
                'icon' => 'heroicon-s-star',
                'route' => 'scores',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $reportes, //7
                'name' => 'Usuarios',
                'order' => 0,
                'icon' => 'heroicon-s-users',
                'route' => null,
                'route-group' => 'reports.users',
                'active' => true
            ],
            [
                'menu_id' => $reportes,
                'name' => 'Cupones', //8
                'order' => 1,
                'icon' => 'heroicon-s-tag',
                'route' => null,
                'route-group' => 'reports.coupons',
                'active' => true
            ],
            [
                'menu_id' => $reportes,
                'name' => 'Ventas', //9
                'order' => 2,
                'icon' => 'heroicon-s-currency-dollar',
                'route' => null,
                'route-group' => 'reports.sales',
                'active' => true
            ],
            [
                'menu_id' => $reportes,
                'name' => 'Globales', //10
                'order' => 3,
                'icon' => 'heroicon-s-globe',
                'route' => null,
                'route-group' => 'reports.globals',
                'active' => true
            ],
            [
                'menu_id' => $reportes,
                'name' => 'Saldo disponible', //11
                'order' => 4,
                'icon' => 'heroicon-s-credit-card',
                'route' => 'reports.balance',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $admin,
                'name' => 'Usuarios',
                'order' => 0,
                'icon' => 'heroicon-s-user-circle',
                'route' => 'users.index',
                'route-group' => null,
                'active' => false
            ],
            [
                'menu_id' => $admin,
                'name' => 'Roles',
                'order' => 1,
                'icon' => 'heroicon-s-identification',
                'route' => 'roles.index',
                'route-group' => null,
                'active' => false
            ],
            [
                'menu_id' => $admin,
                'name' => 'Permisos',
                'order' => 2,
                'icon' => 'heroicon-s-lock-closed',
                'route' => 'permissions.index',
                'route-group' => null,
                'active' => false
            ],
            [
                'menu_id' => $admin,
                'name' => 'Grupos',
                'order' => 3,
                'icon' => 'heroicon-s-office-building',
                'route' => 'groups.index',
                'route-group' => null,
                'active' => false
            ],
            [
                'menu_id' => $admin,
                'name' => 'Establecimientos',
                'order' => 4,
                'icon' => 'heroicon-s-home',
                'route' => 'stores.index',
                'route-group' => null,
                'active' => false
            ],
            [
                'menu_id' => $admin,
                'name' => 'Menús',
                'order' => 5,
                'icon' => 'heroicon-s-menu-alt-2',
                'route' => null,
                'route-group' => null,
                'active' => false
            ],
            [
                'menu_id' => $admin,
                'name' => 'Respuestas',
                'order' => 6,
                'icon' => 'heroicon-s-chat-alt',
                'route' => 'response.index',
                'route-group' => null,
                'active' => false
            ]
        ];
        DB::table('menus')->insert($groups);

        //Crear links dentro de grupos
        $r_usuarios = DB::table('menus')->where('route-group', 'reports.users')->first()->id;
        $r_cupones = DB::table('menus')->where('route-group', 'reports.coupons')->first()->id;
        $r_ventas = DB::table('menus')->where('route-group', 'reports.sales')->first()->id;
        $r_globales = DB::table('menus')->where('route-group', 'reports.globals')->first()->id;

        $reportes_links = [
            [
                'menu_id' => $r_usuarios,
                'name' => 'Nuevos usuarios',
                'order' => 0,
                'icon' => null,
                'route' => 'reports.users.new',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_usuarios,
                'name' => 'Acumulado',
                'order' => 1,
                'icon' => null,
                'route' => 'reports.users.history',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_cupones,
                'name' => 'Impresos',
                'order' => 0,
                'icon' => null,
                'route' => 'reports.coupons.printed',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_cupones,
                'name' => 'Canjeados',
                'order' => 1,
                'icon' => null,
                'route' => 'reports.coupons.redeemed',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_cupones,
                'name' => 'Detallado de cupones canjeados',
                'order' => 2,
                'icon' => null,
                'route' => 'reports.coupons.detail-redeemed',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_cupones,
                'name' => 'Último cupón',
                'order' => 3,
                'icon' => null,
                'route' => 'reports.coupons.last-printed',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_cupones,
                'name' => 'Impresos vs Canjeados',
                'order' => 4,
                'icon' => null,
                'route' => 'reports.coupons.printed-redeemed',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_cupones,
                'name' => 'Acumulado canjeados e impresos',
                'order' => 5,
                'icon' => null,
                'route' => 'reports.coupons.printed-redeemed-history',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_ventas,
                'name' => 'Detallado',
                'order' => 0,
                'icon' => null,
                'route' => 'reports.sales.detail',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_ventas,
                'name' => 'Acumulado',
                'order' => 1,
                'icon' => null,
                'route' => 'reports.sales.history',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_ventas,
                'name' => 'Ventas realizadas',
                'order' => 2,
                'icon' => null,
                'route' => 'reports.sales.sales',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_globales,
                'name' => 'Canjes diarios',
                'order' => 0,
                'icon' => null,
                'route' => 'reports.globals.redeems',
                'route-group' => null,
                'active' => true
            ],
            [
                'menu_id' => $r_globales,
                'name' => 'Altas diarias',
                'order' => 1,
                'icon' => null,
                'route' => 'reports.globals.registers',
                'route-group' => null,
                'active' => true
            ]
        ];

        DB::table('menus')->insert($reportes_links);
    }
}
