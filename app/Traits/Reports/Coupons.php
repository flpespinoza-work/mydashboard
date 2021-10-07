<?php

namespace App\Traits\Reports;

use App\Models\Store;
use Illuminate\Support\Facades\DB;

trait Coupons
{
    function getPrintedCoupons($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportId = 'reporte-cupones-impresos' . fnGenerateReportId($filters);
        $filters['budget'] = fnGetBudget($filters['store']);
        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember($reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $totales = [ 'printed_coupons' => 0, 'printed_amount' => 0, 'printed_sale' => 0];
            $tokDB->table('dat_reporte_cupones_impresos')
            ->selectRaw('DATE_FORMAT(REP_IMP_CUPON_FECHA_HORA, "%d/%m/%Y") day, COUNT(REP_IMP_ID) coupons, SUM(REP_IMP_CUPON_MONTO) amount')
            ->where('REP_IMP_CUPON_PRESUPUESTO', $filters['budget'])
            ->whereBetween('REP_IMP_CUPON_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->groupBy('day')
            ->orderBy('day')
            ->chunk(1000, function($coupons) use(&$tmpRes, &$totales) {
                foreach($coupons as $coupon)
                {
                    $totales['printed_coupons'] += $coupon->coupons;
                    $totales['printed_amount'] += $coupon->amount;
                    $totales['printed_sale'] += $coupon->amount;
                    $tmpRes['coupons'][$coupon->day] = [
                        'day' => $coupon->day,
                        'count' => $coupon->coupons,
                        'amount' => $coupon->amount
                    ];
                }
            });

            if(!empty($tmpRes))
            {
                uksort($tmpRes['coupons'], function($a, $b){
                    return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));
                });

                $aggr = 0;
                foreach($tmpRes['coupons'] as &$coupon)
                {
                    $aggr += $coupon['amount'];
                    $coupon['aggr'] = $aggr;
                }

                $tmpRes['totals'] = $totales;
                $tmpRes['totals']['average_amount'] = number_format($totales['printed_amount'] / $totales['printed_coupons'], 2);
                $tmpRes['totals']['average_sale'] = number_format($totales['printed_sale'] / $totales['printed_coupons'], 2);
            }

            return $tmpRes;
        });

        if(isset($result['coupons']))
            $result['report_id'] = $reportId;

        return $result;
    }

    function getRedeemedCoupons($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportId = 'reporte-cupones-canjeados' . fnGenerateReportId($filters);
        $filters['giftcard'] = fnGetGiftcard($filters['store']);
        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember($reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $totales = [ 'redeemed_coupons' => 0, 'redeemed_amount' => 0];

            $tokDB->table('dat_reporte_cupones_canjeados')
            ->selectRaw('DATE_FORMAT(REP_CAN_CUPON_CANJE_FECHA_HORA, "%d/%m/%Y") DIA, COUNT(REP_CAN_ID) CANJES, SUM(REP_CAN_CUPON_MONTO) MONTO, AVG(REP_CAN_CUPON_MONTO) PROMEDIO_CANJE')
            ->where('REP_CAN_CUPON_GIFTCARD', $filters['giftcard'])
            ->whereBetween('REP_CAN_CUPON_CANJE_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->groupBy('DIA')
            ->orderBy('DIA', 'asc')
            ->chunk(1000, function($coupons) use(&$tmpRes, &$totales) {
                foreach($coupons as $coupon)
                {
                    $totales['redeemed_coupons'] += $coupon->CANJES;
                    $totales['redeemed_amount'] += $coupon->MONTO;

                    $tmpRes['coupons'][$coupon->DIA] = [
                        'day' => $coupon->DIA,
                        'count' => $coupon->CANJES,
                        'amount' => $coupon->MONTO,
                        'average' => $coupon->PROMEDIO_CANJE
                    ];
                }
            });

            if(!empty($tmpRes))
            {
                uksort($tmpRes['coupons'], function($a, $b){
                    return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));
                });

                $tmpRes['totals'] = $totales;
                $tmpRes['totals']['average_amount'] = $totales['redeemed_amount'] / $totales['redeemed_coupons'];
            }

            return $tmpRes;
        });

        if(isset($result['coupons']))
            $result['report_id'] = $reportId;

        return $result;
    }

    function getDetailRedeemedCoupons($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportId = 'reporte-cupones-canjeados-detalle' . fnGenerateReportId($filters);
        $filters['budget'] = fnGetBudget($filters['store']);
        $filters['giftcard'] = fnGetGiftcardFull($filters['store']);
        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember($reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $totales = [ 'redeemed_coupons' => 0, 'redeemed_amount' => 0];

            $tokDB->table('dat_reporte_cupones_canjeados')
            ->join('cat_dbm_nodos_usuarios', 'dat_reporte_cupones_canjeados.REP_CAN_CUPON_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->join('bal_tae_saldos', 'cat_dbm_nodos_usuarios.NOD_USU_NODO', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->selectRaw('NOD_USU_NODO USUARIO_NODO, DATE_FORMAT(REP_CAN_CUPON_CANJE_FECHA_HORA, "%d/%m/%Y %H:%i:%s") CANJE_FECHA_HORA, REP_CAN_CUPON_MONTO CANJE_MONTO, REP_CAN_CUPON_GIFTCARD GIFTCARD_CUPON, TAE_SAL_MONTO SALDO_USUARIO, REP_CAN_CUPON_CODIGO CODIGO_CUPON, DATE_FORMAT(REP_CAN_CUPON_FECHA_HORA, "%d/%m/%Y %H:%i:%s") CUPON_FECHA_HORA, REP_CAN_CUPON_CANJE_ID ID_CUPON')
            ->where('REP_CAN_CUPON_PRESUPUESTO', $filters['budget'])
            ->where('TAE_SAL_BOLSA', $filters['giftcard'])
            ->whereBetween('REP_CAN_CUPON_CANJE_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->orderBy('CANJE_FECHA_HORA')
            ->orderBy('USUARIO_NODO')
            ->chunk(1000, function($coupons) use(&$tmpRes, &$totales) {
                foreach($coupons as $coupon)
                {
                    $totales['redeemed_coupons'] += 1;
                    $totales['redeemed_amount'] += $coupon->CANJE_MONTO;

                    $tmpRes['coupons'][] = [
                        'user' => $coupon->USUARIO_NODO,
                        'coupon_code' => $coupon->CODIGO_CUPON,
                        'date_coupon' => $coupon->CUPON_FECHA_HORA,
                        'date_redeem' => $coupon->CANJE_FECHA_HORA,
                        'amount_redeem' => $coupon->CANJE_MONTO,
                        'user_balance' => $coupon->SALDO_USUARIO
                    ];
                }
            });
            if(!empty($tmpRes))
            {
                usort($tmpRes['coupons'], function($a, $b){
                    return strtotime(str_replace('/', '-', $a['date_coupon'])) - strtotime(str_replace('/', '-', $b['date_coupon']));
                });

                $tmpRes['totals'] = $totales;
                $tmpRes['totals']['average_amount'] = $totales['redeemed_amount'] / $totales['redeemed_coupons'];
            }

            return $tmpRes;

        });

        if(isset($result['coupons']))
            $result['report_id'] = $reportId;

        return $result;
    }

    function getPrintedRedeemedCoupons($filters)
    {
        $reportId = 'reporte-cupones-impresos-canjeados' . fnGenerateReportId($filters);
        $rememberReport = fnRememberReportTime($filters['final_date']);
        $result = cache()->remember($reportId, $rememberReport, function() use ($filters){
            $pr = [];
            $printed = $this->getPrintedCoupons($filters);
            $redeemed = $this->getRedeemedCoupons($filters);
            $coupons = array_merge_recursive($printed, $redeemed);
            if(count($coupons))
            {
                uksort($coupons['coupons'], function($a, $b){
                    return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));
                });

                foreach($coupons['coupons'] as $day => $data)
                {
                    $pr['coupons'][$day] = [
                        'day' => $day,
                        'printed' => $data['count'][0],
                        'redeemed' => $data['count'][1],
                        'printed_amount' => $data['amount'][0],
                        'redeemed_amount' => $data['amount'][1]
                    ];
                }

                $pr['totals'] = [
                    'avg_printed' => $coupons['totals']['average_amount'][0],
                    'avg_redeemed' => $coupons['totals']['average_amount'][1],
                    'printed' => $coupons['totals']['printed_coupons'],
                    'printed_amount' => $coupons['totals']['printed_amount'],
                    'redeemed' => $coupons['totals']['redeemed_coupons'],
                    'redeemed_amount' => $coupons['totals']['redeemed_amount']

                ];
            }

            return $pr;
        });

        if(isset($result['coupons']))
            $result['report_id'] = $reportId;

        return $result;
    }

    function getRedeemedHistoryCoupons($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportId = fnGenerateReportId($filters);
        $filters['giftcard'] = fnGetGiftcard($filters['store']);
        $rememberReport = fnRememberReportTime(date('Y-m-d'));

        $result = cache()->remember('reporte-cupones-canjeados-historico' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('dat_reporte_cupones_canjeados')
            ->selectRaw('COUNT(1) redeems, SUM(REP_CAN_CUPON_MONTO) amount')
            ->where('REP_CAN_CUPON_GIFTCARD', $filters['giftcard'])
            ->get()
            ->toArray();
        });

        if(count($result))
            return ['redeems' => $result[0]->redeems, 'amount' =>$result[0]->amount ];

        return ['redeems' => '0', 'amount' => '0'];
    }

    function getPrintedHistoryCoupons($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportId = fnGenerateReportId($filters);
        $filters['budget'] = fnGetBudget($filters['store']);
        $rememberReport = fnRememberReportTime(date('Y-m-d'));

        $result = cache()->remember('reporte-cupones-impresos-historio' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('dat_reporte_cupones_impresos')
            ->selectRaw('COUNT(1) printed, SUM(REP_IMP_CUPON_MONTO) amount')
            ->where('REP_IMP_CUPON_PRESUPUESTO', $filters['budget'])
            ->get()
            ->toArray();
        });

        if(count($result))
            return ['printed' => $result[0]->printed, 'amount' =>$result[0]->amount ];

        return ['printed' => '0', 'amount' => '0'];
    }

    function getLastPrintedCoupon()
    {
        $tokDB = DB::connection('reportes');
        $filters['budgets'] = fnGetAllBudgets();

        $result = cache()->remember('last-printed-coupon-report', 60*1, function() use($tokDB, $filters){
            return $tokDB->table('dat_reporte_cupones_impresos')
            ->selectRaw('MAX(REP_IMP_CUPON_FECHA_HORA) date, REP_IMP_CUPON_PRESUPUESTO budget, REP_IMP_CUPON_MONTO amount')
            ->whereIn('REP_IMP_CUPON_PRESUPUESTO', $filters['budgets'])
            ->groupBy('REP_IMP_CUPON_PRESUPUESTO')
            ->orderBy('date', 'desc')
            ->get()
            ->toArray();
        });

        //Obtener los nombres y diferencia de tiempo
        $now = strtotime(date('Y-m-d H:i:s'));
        foreach($result as &$coupon)
        {
            $name = Store::where('budget', $coupon->budget)->first()->name;
            $coupon->store_name = $name;
            $coupon_printed = strtotime($coupon->date);
            $coupon->diff = round(($now-$coupon_printed) / 60);
            $coupon->date = date('d/m/Y H:i:s', strtotime($coupon->date));
        }

        //Ordenar alfabeticamente
        /*usort($result, function($a, $b) {
            return $a->store_name <=> $b->store_name;
        });*/

        return $result;
    }
}
