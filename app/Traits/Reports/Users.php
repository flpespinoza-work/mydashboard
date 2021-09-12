<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

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
            $tmpResult = [];
            $totalUsers = 0;

            $tokDB->table('cat_dbm_nodos_usuarios')
            ->join('bal_tae_saldos', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('DATE_FORMAT(TAE_SAL_TS, "%Y/%m/%d") day, COUNT(NOD_USU_ID) users'))
            ->where('TAE_SAL_BOLSA', $filters['giftcard'])
            ->whereBetween('TAE_SAL_TS', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('day')
            ->groupBy('TAE_SAL_BOLSA')
            ->orderBy('day')
            ->chunk(10, function($users) use(&$tmpRes, &$totalUsers) {
                foreach($users as $user)
                {
                    $totalUsers += $user->users;
                    $tmpRes['data'][] = [
                        'day' => $user->day,
                        'users' => $user->users
                    ];
                }
            });
            $tmpRes['totals'] = $totalUsers;
            return $tmpRes;

            return $tmpResult;

        });
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
}
