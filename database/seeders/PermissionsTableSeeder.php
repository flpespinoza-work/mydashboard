<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $arrayOfPermissions = [
            // Permisos para usuarios,roles
            [
                'name' => 'can_access_dashboard',
                'description' => 'Puede ingresar al modulo de dashboard'
            ],
            [
                'name' => 'can_access_campaigns',
                'description' => 'Puede ingresar al modulo de campañas'
            ],
            [
                'name' => 'can_create_new_campaign',
                'description' => 'Puede crear una nueva campaña'
            ],
            [
                'name' => 'can_suspend_campaign',
                'description' => 'Puede suspender una campaña'
            ],
            [
                'name' => 'can_program_campaign',
                'description' => 'Puede programar una campaña'
            ],
            [
                'name' => 'can_send_campaign',
                'description' => 'Puede enviar una campaña'
            ],
            [
                'name' => 'can_see_campaign',
                'description' => 'Puede medir una campaña'
            ],
            [
                'name' => 'can_test_campaign',
                'description' => 'Puede probar una campaña'
            ],
            [
                'name' => 'can_access_scores',
                'description' => 'Puede ingresar al modulo de calificaciones'
            ],
            [
                'name' => 'can_access_new_users_report',
                'description' => 'Puede ingresar al reporte de nuevos usuarios'
            ],
            [
                'name' => 'can_access_history_users_report',
                'description' => 'Puede ingresar al reporte acumulado de usuarios'
            ],
            [
                'name' => 'can_access_printed_coupons_report',
                'description' => 'Puede ingresar al reporte de cupones impresos'
            ],
            [
                'name' => 'can_access_redeemed_coupons_report',
                'description' => 'Puede ingresar al reporte de cupones canjeados'
            ],
            [
                'name' => 'can_access_detail_redeemed_coupons_report',
                'description' => 'Puede ingresar al reporte detallado de cupones canjeados'
            ],
            [
                'name' => 'can_access_last_coupon_report',
                'description' => 'Puede ingresar al reporte de ultimo cupon'
            ],
            [
                'name' => 'can_access_printed_redeemed_coupons_report',
                'description' => 'Puede ingresar al reporte de cupones impresos vs canjeados'
            ],
            [
                'name' => 'can_access_detail_sales_report',
                'description' => 'Puede ingresar al reporte detallado de ventas'
            ],
            [
                'name' => 'can_access_history_sales_report',
                'description' => 'Puede ingresar al reporte acumulado de ventas'
            ],
            [
                'name' => 'can_access_sales_report',
                'description' => 'Puede ingresar al reporte ventas realizadas'
            ],
            [
                'name' => 'can_access_globals_redeems_report',
                'description' => 'Puede ingresar al reporte global de canjes diarios'
            ],
            [
                'name' => 'can_access_global_users_report',
                'description' => 'Puede ingresar al reporte global de altas diarias'
            ],
            [
                'name' => 'can_access_balance_report',
                'description' => 'Puede ingresar al reporte de saldo disponible'
            ],
            [
                'name' => 'can_access_users_module',
                'description' => 'Puede ingresar al modulo de usuarios'
            ],
            [
                'name' => 'can_access_create_users_module',
                'description' => 'Puede ingresar al modulo de crear usuarios'
            ],
            [
                'name' => 'can_access_roles_module',
                'description' => 'Puede ingresar al modulo de roles'
            ],
            [
                'name' => 'can_create_new_role',
                'description' => 'Puede añadir un nuevo rol'
            ],
            [
                'name' => 'can_access_permissions_module',
                'description' => 'Puede ingresar al modulo de permisos'
            ],
            [
                'name' => 'can_access_groups_module',
                'description' => 'Puede ingresar al modulo de grupos'
            ],
            [
                'name' => 'can_create_new_group',
                'description' => 'Puede crear un nuevo grupo'
            ],
            [
                'name' => 'can_access_stores_module',
                'description' => 'Puede ingresar al modulo de establecimientos'
            ],
            [
                'name' => 'can_create_new_store',
                'description' => 'Puede crear/importar nuevos establecimientos'
            ],
            [
                'name' => 'can_access_menu_module',
                'description' => 'Puede ingresar al modulo de menus'
            ],
            [
                'name' => 'can_create_new_menu',
                'description' => 'Puede crear un nuevo menu'
            ],
            [
                'name' => 'can_access_response_modules',
                'description' => 'Puede ingresar al modulo de respuestas'
            ],
            [
                'name' => 'can_create_new_response',
                'description' => 'Puede crear una nueva respuesta'
            ]
        ];

        $permissions = collect($arrayOfPermissions)->map(function($permission){
            return [
                'name' => $permission['name'],
                'guard_name' => 'web',
                'description' => $permission['description']
            ];
        });

        DB::table('permissions')->insert($permissions->toArray());
    }
}

