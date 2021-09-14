<?php

namespace App\Traits\Reports;

use App\Models\Store;
use Illuminate\Support\Facades\DB;

trait Globals
{
    function getRedeems($filters)
    {
        //sin periodo la fecha inicial es 2018-01-01
        $result = [];
        $tokDB = DB::connection('reportes');
        $reportId = fnGenerateReportId($filters);
        if($filters['store'] == 'all')
            $filters['giftcards'] = fnGetAllGiftcards($filters['store']);
        else
            $filters['giftcards'] = fnGetGiftcard($filters['store']);

        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $result = cache()->remember('global-redeems-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes= [];
            $query =  $tokDB->table('dat_reporte_cupones_canjeados')
            ->selectRaw('DATE_FORMAT(REP_CAN_CUPON_CANJE_FECHA_HORA, "%d/%m/%Y") day, COUNT(1) redeems, SUM(REP_CAN_CUPON_MONTO) amount, REP_CAN_CUPON_GIFTCARD giftcard');
            if(is_array($filters['giftcards']))
                $query->whereIn('REP_CAN_CUPON_GIFTCARD', $filters['giftcards']);
            else
                $query->where('REP_CAN_CUPON_GIFTCARD', $filters['giftcards']);

            $query->whereBetween('REP_CAN_CUPON_CANJE_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->groupBy('day','REP_CAN_CUPON_GIFTCARD')
            ->orderBy('day')
            ->chunk(50, function($redeems) use(&$tmpRes){
                foreach($redeems as $redeem)
                {
                    $tmpRes['redeems'][] = [
                        'day' => $redeem->day,
                        'giftcard' => $redeem->giftcard,
                        'redeems' => $redeem->redeems,
                        'amount' => $redeem->amount
                    ];
                }
            });
            return $tmpRes;
        });

        if(count($result))
        {
            foreach($result['redeems'] as &$redeem)
            {
                $name = Store::where('giftcard', $redeem['giftcard'])->first()->name;
                $redeem['store_name'] = $name;
            }
            //Ordenar alfabeticamente
            usort($result['redeems'], function($a, $b) {
                return $a['store_name'] <=> $b['store_name'];
            });

            usort($result['redeems'], function($a, $b){
                return strtotime(str_replace('/', '-', $a['day'])) - strtotime(str_replace('/', '-', $b['day']));
            });
        }

        return $result;
    }

    function getRegisters($filters)
    {
        //sin periodo la fecha inicial es 2018-01-01
        $result = [];
        $tokDB = DB::connection('reportes');
        $reportId = fnGenerateReportId($filters);
        if($filters['store'] == 'all')
            $filters['giftcards'] = fnGetAllGiftcardsFull();
        else
            $filters['giftcards'] = fnGetGiftcardFull($filters['store']);

        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $result = cache()->remember('global-registers-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $totals = ['users' => 0];
            $query = $tokDB->table('bal_tae_saldos')
            ->join('cat_dbm_nodos_usuarios', 'bal_tae_saldos.TAE_SAL_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->selectRaw('DATE_FORMAT(TAE_SAL_TS, "%d/%m/%Y") day, COUNT(1) users, TAE_SAL_BOLSA bag')
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
                        'bag'=> $register->bag,
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

        if(count($result))
        {
            foreach($result['registers'] as &$register)
            {
                $name = Store::where('giftcard', str_replace('GIFTCARD_', '', $register['bag']))->first()->name;
                $register['store_name'] = $name;
            }

            //Ordenar alfabeticamente
            usort($result['registers'], function($a, $b) {
                return $a['store_name'] <=> $b['store_name'];
            });

            //Ordenar por dia
            usort($result['registers'], function($a, $b) {
                return strtotime(str_replace('/', '-', $a['day'])) - strtotime(str_replace('/', '-', $b['day']));
            });
        }

        return $result;
    }
}
