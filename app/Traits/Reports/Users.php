<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

trait Users
{
    function getNewUsers($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportId = fnGenerateReportId($filters);
        $filters['giftcard'] = fnGetGiftcardFull($filters['store']);
        $rememberReport = fnRememberReportTime($filters['final_date']);
        //dd($filters);
        $result = cache()->remember('new-users-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $totalUsers = 0;

            $tokDB->table('cat_dbm_nodos_usuarios')
            ->join('bal_tae_saldos', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('DATE_FORMAT(TAE_SAL_TS, "%d/%m/%Y") day, COUNT(NOD_USU_ID) users'))
            ->where('TAE_SAL_BOLSA', $filters['giftcard'])
            ->whereBetween('TAE_SAL_TS', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('day')
            ->groupBy('TAE_SAL_BOLSA')
            ->orderBy('day')
            ->chunk(1000, function($users) use(&$tmpRes, &$totalUsers) {
                foreach($users as $user)
                {
                    $totalUsers += $user->users;
                    $tmpRes['data'][] = [
                        'day' => $user->day,
                        'users' => $user->users
                    ];
                }
            });
            if(count($tmpRes))
                $tmpRes['totals'] = $totalUsers;

            return $tmpRes;

        });

        if(count($result))
        {
            usort($result['data'], function($a, $b){
                return strtotime(str_replace('/', '-', $a['day'])) - strtotime(str_replace('/', '-', $b['day']));
            });
        }

        return $result;
    }

    function getHistoryUsers($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportId = md5(session()->getId() . $filters['store']);
        $filters['giftcard'] = fnGetGiftcardFull($filters['store']);
        $rememberReport = 600;

        $result = cache()->remember('history-users-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $tokDB->table('cat_dbm_nodos_usuarios')
            ->join('bal_tae_saldos', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('TAE_SAL_BOLSA BOLSA, SUM(TAE_SAL_MONTO) MONTO, COUNT(NOD_USU_ID) USUARIOS'))
            ->where('TAE_SAL_BOLSA', $filters['giftcard'])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('TAE_SAL_BOLSA')
            ->orderBy('TAE_SAL_BOLSA')
            ->chunk(10, function($users) use(&$tmpRes) {
                foreach($users as $user)
                {
                    $tmpRes['data'][] = [
                        'users' => $user->USUARIOS,
                        'amount' => $user->MONTO,
                        'avg' => $user->MONTO / $user->USUARIOS
                    ];
                }
            });
            return $tmpRes;
        });

        return $result;
    }

    function getUserActivity($filters)
    {
        //inicializar datos
        $tokDB = DB::connection('reportes');
        $reportId = fnGenerateReportId($filters);
        $filters['giftcard'] = fnGetGiftcardFull($filters['store']);
        $filters['budget'] = fnGetBudget($filters['store']);
        $filters['node'] = fnGetTokencashNode($filters['store']);
        $result = [];

        $rememberReport = fnRememberReportTime($filters['final_date']);
        //Obtener informacion general(ID Usuario, nombre usuario, telefono, correo, fecha alta, estado)
        $userInfo = cache()->remember('activity-users-report-info' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('cat_dbm_nodos_usuarios')
            ->join('cat_dbm_nodos', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', 'cat_dbm_nodos.NOD_ID')
            ->join('bal_tae_saldos', 'cat_dbm_nodos.NOD_ID', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->selectRaw("NOD_USU_NODO NODO, DATE_FORMAT(NOD_USU_TS, '%e %M %Y') FECHA_ALTA, NOD_USU_NOMBRE NOMBRE, NOD_USU_CORREO CORREO, NOD_USU_NUMERO NUMERO, NOD_USU_CONFIGURACION CONFIG, TAE_SAL_MONTO SALDO")
            ->where('TAE_SAL_BOLSA', $filters['giftcard'])
            ->where('NOD_USU_NODO', $filters['user'])
            ->get();
        });

        if($userInfo->isEmpty())
        {
            return [];
        }
        else
        {
            $result['info'] = $userInfo->first();
        }

        //Obtener cupones canjeados del periodo
        $userRedeems = cache()->remember('activity-users-report-redeems' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('dat_reporte_cupones_canjeados')
            ->join('cat_dbm_nodos_usuarios', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', 'dat_reporte_cupones_canjeados.REP_CAN_CUPON_NODO')
            ->selectRaw("REP_CAN_CUPON_CANJE_FECHA_HORA CANJE, REP_CAN_CUPON_FECHA_HORA IMPRESION, REP_CAN_CUPON_ID ID, REP_CAN_CUPON_CODIGO CODIGO, REP_CAN_CUPON_MONTO MONTO")
            ->whereBetween('REP_CAN_CUPON_CANJE_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->where('NOD_USU_NODO', $filters['user'])
            ->where('REP_CAN_CUPON_PRESUPUESTO', $filters['budget'])
            ->orderBy('REP_CAN_CUPON_CANJE_FECHA_HORA')
            ->get();
        });

        if($userRedeems->isEmpty())
        {
            $result['redeems'] = [];
        }
        else
        {
            $result['redeems'] = $userRedeems->toArray();
            $result['redeems_day'] = ['L' => 0, 'Ma' => 0, 'Mi' => 0, 'J' => 0, 'V' => 0, 'S' => 0, 'D' => 0];
            foreach($userRedeems as $redeem)
            {
                $day = date('l', strtotime($redeem->IMPRESION));
                switch($day)
                {
                    case 'Sunday' : $day = 'D'; break;
                    case 'Monday' : $day = 'L'; break;
                    case 'Tuesday' : $day = 'Ma'; break;
                    case 'Wednesday' : $day = 'Mi'; break;
                    case 'Thursday' : $day = 'J'; break;
                    case 'Friday' : $day = 'V'; break;
                    case 'Saturday' : $day = 'S'; break;
                }

                $result['redeems_day']["{$day}"] += 1;
            }
        }

        //Obtener cupones canjeados totales
        $userRedeemsTotal = cache()->remember('activity-users-report-redeems-total' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('dat_reporte_cupones_canjeados')
            ->join('cat_dbm_nodos_usuarios', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', 'dat_reporte_cupones_canjeados.REP_CAN_CUPON_NODO')
            ->selectRaw("COUNT(1) CANJES, SUM(REP_CAN_CUPON_MONTO) MONTO")
            ->where('NOD_USU_NODO', $filters['user'])
            ->where('REP_CAN_CUPON_PRESUPUESTO', $filters['budget'])
            ->get();
        });

        if($userRedeemsTotal->isEmpty())
        {
            $result['redeems_total'] = [];
        }
        else
        {
            $result['redeems_total'] = $userRedeemsTotal->first();
        }

        //Obtener ventas del periodo
        $userSales = cache()->remember('activity-users-report-sales' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', 'doc_dbm_ventas.VEN_NODO')
            ->selectRaw("VEN_ID ID, VEN_FECHA_HORA FECHA, VEN_MONTO MONTO")
            ->whereBetween('VEN_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->where('VEN_DESTINO', $filters['node'])
            ->where('VEN_NODO', $filters['user'])
            ->where('VEN_ESTADO', 'VIGENTE')
            ->orderBy('VEN_FECHA_HORA')
            ->get();
        });

        if($userSales->isEmpty())
        {
            $result['sales'] = [];
        }
        else
        {
            $result['sales'] = $userSales->toArray();
            $result['sales_day'] = ['L' => 0, 'Ma' => 0, 'Mi' => 0, 'J' => 0, 'V' => 0, 'S' => 0, 'D' => 0];
            foreach($userSales as $sale)
            {
                $day = date('l', strtotime($sale->FECHA));
                switch($day)
                {
                    case 'Sunday' : $day = 'D'; break;
                    case 'Monday' : $day = 'L'; break;
                    case 'Tuesday' : $day = 'Ma'; break;
                    case 'Wednesday' : $day = 'Mi'; break;
                    case 'Thursday' : $day = 'J'; break;
                    case 'Friday' : $day = 'V'; break;
                    case 'Saturday' : $day = 'S'; break;
                }

                $result['sales_day']["{$day}"] += 1;
            }
        }

        //Obtener ventas totales
        $userSalesTotal = cache()->remember('activity-users-report-sales-total' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', 'doc_dbm_ventas.VEN_NODO')
            ->selectRaw("COUNT(1) VENTAS, SUM(VEN_MONTO) MONTO")
            ->where('VEN_DESTINO', $filters['node'])
            ->where('VEN_NODO', $filters['user'])
            ->where('VEN_ESTADO', 'VIGENTE')
            ->get();
        });

        if($userSalesTotal->isEmpty())
        {
            $result['sales_total'] = [];
        }
        else
        {
            $result['sales_total'] = $userSalesTotal->first();
        }

        return $result;
    }
}
