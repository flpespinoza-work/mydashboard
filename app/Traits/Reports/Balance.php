<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Balance
{
    function getStoresBalance()
    {
        $tokDB = DB::connection('reportes');
        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $reportId = md5(session()->getId());
        $filters = getMyStoresData();

        $result = cache()->remember('balance-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $tokDB->table('cat_dbm_nodos')
            ->join('bal_tae_saldos', 'cat_dbm_nodos.NOD_ID', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('NOD_ID, NOD_CODIGO, TAE_SAL_MONTO, TAE_SAL_NODO, TAE_SAL_BOLSA'))
            ->whereIn('TAE_SAL_NODO', $filters['nodes'])
            ->whereIn('TAE_SAL_BOLSA', $filters['budgets'])
            ->orderBy('TAE_SAL_NODO')
            ->chunk(10, function($balances) use(&$tmpRes) {
                foreach($balances as $balance)
                {
                    $tmpRes['balances'][] = [
                        'node' => $balance->NOD_ID,
                        'node_code' => $balance->NOD_CODIGO,
                        'balance' => $balance->TAE_SAL_MONTO,
                        'balance_node' => $balance->TAE_SAL_NODO,
                        'balance_budget' => $balance->TAE_SAL_BOLSA
                    ];
                }
            });

            return $tmpRes;
        });

        return $result;
    }
}
