<?php

namespace App\Traits\Reports;

use App\Models\Store;
use Illuminate\Support\Facades\DB;

trait Balance
{
    function getStoresBalance()
    {
        $tokDB = DB::connection('reportes');
        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $reportId = md5(session()->getId());
        $nodes = fnGetMyStoresNodes();
        $budgets = fnGetAllBudgetsFull();

        $result = cache()->remember('balance-report' . $reportId, $rememberReport, function() use($tokDB, $nodes, $budgets){
            $tmpRes = [];
            $tokDB->table('cat_dbm_nodos')
            ->join('bal_tae_saldos', 'cat_dbm_nodos.NOD_ID', '=', 'bal_tae_saldos.TAE_SAL_NODO')
            ->select(DB::raw('NOD_ID, NOD_CODIGO, TAE_SAL_MONTO, TAE_SAL_NODO, TAE_SAL_BOLSA'))
            ->whereIn('TAE_SAL_NODO', $nodes)
            ->whereIn('TAE_SAL_BOLSA', $budgets)
            ->orderBy('TAE_SAL_NODO')
            ->chunk(100, function($balances) use(&$tmpRes) {
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

        if(count($result))
        {
            //Obtener los nombres
            foreach($result['balances'] as &$balance)
            {
                $name = Store::where('node', $balance['node'])->first()->name;
                $balance['store_name'] = $name;
            }
            //Ordenar alfabeticamente
            usort($result['balances'], function($a, $b) {
                return $a['store_name'] <=> $b['store_name'];
            });

            return $result;
        }


    }
}
