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
        $reportId = 'global-redeems-report' . fnGenerateReportId($filters);
        if($filters['store'] == 'all')
            $filters['giftcards'] = fnGetAllGiftcards($filters['store']);
        else
            $filters['giftcards'] = fnGetGiftcard($filters['store']);

        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $result = cache()->remember($reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes= [];
            $query =  $tokDB->table('dat_reporte_cupones_canjeados')
            ->selectRaw('DATE_FORMAT(REP_CAN_CUPON_CANJE_FECHA_HORA, "%d/%m/%Y") day, COUNT(1) redeems, REP_CAN_CUPON_GIFTCARD giftcard');
            if(is_array($filters['giftcards']))
                $query->whereIn('REP_CAN_CUPON_GIFTCARD', $filters['giftcards']);
            else
                $query->where('REP_CAN_CUPON_GIFTCARD', $filters['giftcards']);

            $query->whereBetween('REP_CAN_CUPON_CANJE_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->groupBy('day','REP_CAN_CUPON_GIFTCARD')
            ->orderBy('day', 'asc')
            ->chunk(1000, function($redeems) use(&$tmpRes){
                foreach($redeems as $redeem)
                {
                    $name = Store::where('giftcard', $redeem->giftcard)->first()->name;
                    $tmpRes['days'][] = $redeem->day;
                    $tmpRes['redeems'][$name][$redeem->day] = $redeem->redeems;
                }
            });

            if(count($tmpRes))
            {
                //Eliminar dias duplicados
                $tmpRes['days'] = array_values(array_unique($tmpRes['days']));
                usort($tmpRes['days'], function($a,$b){
                    return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));
                });


                //Ordenar alfabeticamente
                uksort($tmpRes['redeems'], function($a,$b){
                    return $a <=> $b;
                });

                //Agregar los dias que no hay altas en 0 para cada establecimiento
                foreach($tmpRes['days'] as $day)
                {
                    foreach($tmpRes['redeems'] as $store => $redeems)
                    {
                        if(!isset($tmpRes['redeems'][$store][$day]))
                        {
                            $tmpRes['redeems'][$store][$day] = 0;
                        }
                    }
                }

                //Ordenar por fecha
                foreach($tmpRes['redeems'] as $store => &$redeems)
                {
                    uksort($redeems, function($a, $b){
                        return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));;
                    });
                }

                //Obtener totales
                if(count($tmpRes['redeems']) > 1)
                {
                    $totals = [];
                    foreach($tmpRes['redeems'] as $store => $days)
                    {
                        foreach($days as $day => $amount)
                        {
                            isset($totals["{$day}"]) ? $totals["{$day}"] += $amount : $totals["{$day}"] = $amount;
                        }
                    }

                    //Ordenar totales por fecha
                    uksort($totals, function($a, $b)
                    {
                        return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));;
                    });

                    $tmpRes['totals'] = $totals;
                }
            }

            return $tmpRes;
        });

        if(isset($result['redeems']))
            $result['report_id'] = $reportId;
        return $result;
    }

    function getRegisters($filters)
    {
        $result = [];
        $tokDB = DB::connection('reportes');
        $reportId = 'global-registers-report' . fnGenerateReportId($filters);
        if($filters['store'] == 'all')
            $filters['giftcards'] = fnGetAllGiftcardsFull();
        else
            $filters['giftcards'] = fnGetGiftcardFull($filters['store']);

        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $result = cache()->remember($reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
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
            ->chunk(1000, function($registers) use (&$tmpRes, &$totals){
                foreach($registers as $register)
                {
                    $name = Store::where('giftcard', str_replace('GIFTCARD_', '', $register->bag))->first()->name;
                    $tmpRes['days'][] = $register->day;
                    $tmpRes['registers'][trim($name)][$register->day] = $register->users;
                }
            });

            if(count($tmpRes))
            {
                //Eliminar dias duplicados
                $tmpRes['days'] = array_values(array_unique($tmpRes['days']));
                usort($tmpRes['days'], function($a,$b){
                    return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));
                });

                //Ordenar alfabeticamente
                uksort($tmpRes['registers'], function($a, $b) {
                    return $a <=> $b;
                });


                //Agregar los dias que no hay altas en 0 para cada establecimiento
                foreach($tmpRes['days'] as $day)
                {
                    foreach($tmpRes['registers'] as $store => $redeems)
                    {
                        if(!isset($tmpRes['registers'][$store][$day]))
                        {
                            $tmpRes['registers'][$store][$day] = 0;
                        }
                    }
                }

                //Ordenar por fecha
                foreach($tmpRes['registers'] as $store => &$redeems)
                {
                    uksort($redeems, function($a, $b)
                    {
                        return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));;
                    });
                }

                //Obtener totales
                if(count($tmpRes['registers']) > 1)
                {
                    $totals = [];
                    foreach($tmpRes['registers'] as $store => $days)
                    {
                        foreach($days as $day => $users)
                        {
                            isset($totals["{$day}"]) ? $totals["{$day}"] += $users : $totals["{$day}"] = $users;
                        }
                    }

                    //Ordenar totales por fecha
                    uksort($totals, function($a, $b)
                    {
                        return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));;
                    });

                    $tmpRes['totals'] = $totals;

                }
            }

            return $tmpRes;
        });

        if(isset($result['registers']))
            $result['report_id'] = $reportId;

        return $result;
    }
}
