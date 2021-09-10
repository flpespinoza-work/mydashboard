<?php

namespace App\Traits\Dashboard;
use Illuminate\Support\Facades\DB;

trait Data
{
    function getData($filters)
    {
        $balance = $this->getBalance($filters);
        $printed = $this->getPrintedCoupons($filters);
        $redeemed = $this->getRedeemedCoupons($filters);
        //dd($redeemed);
        return [
            'balance' => $balance,
            'printed_coupons' => $printed,
            'redeemed_coupons' => $redeemed
        ];
    }
    function getBalance($filters)
    {
        $tokDB = DB::connection('reportes');
        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $reportId = md5(session()->getId() . $filters['store']);
        $filters['budget'] = fnGetBudgetFull($filters['store']);
        $filters['node'] = fnGetTokencashNode($filters['store']);

        $result = cache()->remember('balance-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('cat_dbm_nodos')
            ->join('bal_tae_saldos', 'cat_dbm_nodos.NOD_ID', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select('TAE_SAL_MONTO')
            ->where('TAE_SAL_NODO', $filters['node'])
            ->where('TAE_SAL_BOLSA', $filters['budget'])
            ->pluck('TAE_SAL_MONTO');
        });
        if(count($result))
            return number_format($result[0], 2);

        return '0.00';

    }

    function getUsers($filters)
    {

    }

    function getPrintedCoupons($filters)
    {
        $tokDB = DB::connection('reportes');
        $filters['budget'] = fnGetBudget($filters['store']);
        $reportId = fnGenerateReportId($filters);
        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember('reporte-cupones-impresos' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('dat_reporte_cupones_impresos')
            ->selectRaw('COUNT(REP_IMP_ID) coupons, SUM(REP_IMP_CUPON_MONTO) amount')
            ->where('REP_IMP_CUPON_PRESUPUESTO', $filters['budget'])
            ->whereBetween('REP_IMP_CUPON_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->get()
            ->toArray();
        });
        //dd($result);
        if(count($result))
            return ['coupons' => $result[0]->coupons, 'amount' =>$result[0]->amount ];

        return ['coupons' => '0', 'amount' => '0'];
    }

    function getRedeemedCoupons($filters)
    {
        $tokDB = DB::connection('reportes');
        $filters['giftcard'] = fnGetGiftcard($filters['store']);
        $reportId = fnGenerateReportId($filters);
        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember('reporte-cupones-canjeados' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('dat_reporte_cupones_canjeados')
            ->selectRaw('COUNT(REP_CAN_ID) redeems, SUM(REP_CAN_CUPON_MONTO) amount')
            ->where('REP_CAN_CUPON_GIFTCARD', $filters['giftcard'])
            ->whereBetween('REP_CAN_CUPON_CANJE_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->get()
            ->toArray();
        });

        if(count($result))
            return ['redeems' => $result[0]->redeems, 'amount' =>$result[0]->amount ];

        return ['redeems' => '0', 'amount' => '0'];
    }

    function getSales($filters)
    {

    }
}
