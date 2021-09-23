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
                'name' => 'can_create_user',
                'description' => 'Puede crear usuarios'
            ],
            [
                'name' => 'can_modifiy_user',
                'description' => 'Puede modificar usuarios'
            ],
            [
                'name' => 'can_delete_user',
                'description' => 'Puede eliminar usuarios'
            ],
            [
                'name' => 'can_create_role',
                'description' => 'Puede crear roles'
            ],
            [
                'name' => 'can_modifiy_role',
                'description' => 'Puede modificar roles'
            ],
            [
                'name' => 'can_delete_role',
                'description' => 'Puede eliminar roles'
            ],
            [
                'name' => 'can_create_permission',
                'description' => 'Puede crear permisos'
            ],
            [
                'name' => 'can_modifiy_permission',
                'description' => 'Puede modificar permisos'
            ],
            [
                'name' => 'can_delete_permission',
                'description' => 'Puede eliminar permisos'
            ],
            // Permisos para reportes
            [
                'name' => 'cupons_report_access',
                'description' => 'Puede descargar al reporte de cupones'
            ],
            [
                'name' => 'sales_report_access',
                'description' => 'Puede descargar al reporte de ventas'
            ],
            [
                'name' => 'users_report_access',
                'description' => 'Puede descargar al reporte de usuarios'
            ],
            [
                'name' => 'indicators_report_access',
                'description' => 'Puede descargar al reporte de indicadores'
            ],
            [
                'name' => 'last_printed_cupon_report_access',
                'description' => 'Puede descargar al reporte de último cupón impreso'
            ],
            [
                'name' => 'balance_report_access',
                'description' => 'Puede descargar al reporte de saldos'
            ],
            // Permisos para comentarios
            [
                'name' => 'can_reply_comment',
                'description' => 'Puede enviar respuesta a un comentario'
            ],
            // Permisos para notificaciones
            [
                'name' => 'can_create_campaign',
                'description' => 'Puede crear nueva campaña'
            ],
            [
                'name' => 'can_test_campaign',
                'description' => 'Puede probar una campaña'
            ],
            [
                'name' => 'can_see_campaign_stats',
                'description' => 'Puede ver las estadísticas de una campaña'
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

