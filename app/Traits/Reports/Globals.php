<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Globals
{
    function getRedeems($filters)
    {
        //sin periodo la fecha inicial es 2018-01-01
        $tokDB = DB::connection('reportes');
        $reportId = fnGenerateReportId($filters);
        if($filters['store'] == 'all')
            $filters['giftcards'] = fnGetAllGiftcards($filters['store']);
        else
            $filters['giftcards'] = fnGetGiftcard($filters['store']);

        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $result = cache()->remember('global-redeems-report' . $reportId, 60*60*24, function() use($tokDB, $filters){
            $tmpRes= [];
            $totals = ['redeems' =>0, 'amount' => 0];
            $query =  $tokDB->table('dat_reporte_cupones_canjeados')
            ->selectRaw('DATE_FORMAT(REP_CAN_CUPON_CANJE_FECHA_HORA, "%Y/%m/%d") day, COUNT(1) redeems, SUM(REP_CAN_CUPON_MONTO) amount, REP_CAN_CUPON_GIFTCARD giftcard');
            if(is_array($filters['giftcards']))
                $query->whereIn('REP_CAN_CUPON_GIFTCARD', $filters['giftcards']);
            else
                $query->where('REP_CAN_CUPON_GIFTCARD', $filters['giftcards']);

            $query->whereBetween('REP_CAN_CUPON_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->orderBy('day')
            ->groupBy('REP_CAN_CUPON_GIFTCARD')
            ->chunk(50, function($redeems) use(&$tmpRes, &$totals){
                foreach($redeems as $redeem)
                {
                    $tmpRes['redeems'][$redeem->giftcard][$redeem->day] = [
                        'day' => $redeem->day,
                        'redeems' => $redeem->redeems,
                        'amount' => $redeem->amount
                    ];
                    $totals['redeems'] += $redeem->redeems;
                    $totals['amount'] += $redeem->amount;
                }
            });
            if(count($tmpRes))
                $tmpRes['totals'] = $totals;
            return $tmpRes;
        });
        dd($result);
        return $result;
    }

    function getRegisters($filters)
    {
        //sin periodo la fecha inicial es 2018-01-01
        $tokDB = DB::connection('reportes');
        $reportId = fnGenerateReportId($filters);
        if($filters['store'] == 'all')
            $filters['giftcards'] = fnGetAllGiftcardsFull();
        else
            $filters['giftcards'] = fnGetGiftcardFull($filters['store']);

        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $result = cache()->remember('global-registers-report' . $reportId, 60*60*24, function() use($tokDB, $filters){
            $tmpRes = [];
            $totals = ['users' => 0];
            $query = $tokDB->table('bal_tae_saldos')
            ->join('cat_dbm_nodos_usuarios', 'bal_tae_saldos.TAE_SAL_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->selectRaw('DATE_FORMAT(TAE_SAL_TS, "%Y/%m/%d") day, COUNT(1) users')
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')");

            if(is_array($filters['giftcards']))
                $query->whereIn('TAE_SAL_BOLSA', $filters['giftcards']);
            else
                $query->where('TAE_SAL_BOLSA', $filters['giftcards']);

            $query->whereBetween('TAE_SAL_TS', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->groupBy('day', 'TAE_SAL_BOLSA')
            ->orderBy('day')
            ->chunk(50, function($registers) use (&$tmpRes, &$totals){
                foreach($registers as $register)
                {
                    $tmpRes['registers'][] = [
                        'day' => $register->day,
                        'users' => $register->users
                    ];
                    $totals['users'] += $register->users;
                }
            });
            if(count($tmpRes))
                $tmpRes['totals'] = $totals;
            return $tmpRes;
        });

        return $result;
    }
}
