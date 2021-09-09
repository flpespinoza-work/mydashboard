<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Sales
{
    function getSales($filters)
    {
        $tokDB = DB::connection('reportes');
        $filters['node'] = fnGetTokencashNode($filters['store']);
        $reportId = fnGenerateReportId($filters);
        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember('sales-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $totalSales = ['sales' => 0, 'amount' => 0];

            $tokDB->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('NOD_USU_NODO, VEN_ID, VEN_FECHA_HORA, VEN_MONTO MONTO_VENTA'))
            ->where('VEN_DESTINO', $filters['node'])
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->where('VEN_BOLSA', 'LIKE', 'GIFTCARD_%')
            ->whereBetween('VEN_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('VEN_ID')
            ->orderBy('VEN_FECHA_HORA', 'desc')
            ->orderBy('NOD_USU_NODO')
            ->chunk(10, function($sales) use(&$tmpRes, &$totalSales) {
                foreach($sales as $sale)
                {
                    $totalSales['sales'] += 1;
                    $totalSales['ammount'] += $sale->MONTO_VENTA;
                    $tmpRes['sales'][] = [
                        'date' => $sale->VEN_FECHA_HORA,
                        'user' => $sale->NOD_USU_NODO,
                        'amount' => $sale->MONTO_VENTA
                    ];
                }
            });

            if(count($tmpRes))
            {
                $tmpRes['totals'] = $totalSales;
                $tmpRes['totals']['average_sale'] = $totalSales['amount'] / $totalSales['sales'];
            }
        });

        return $result;
    }

    function getHistorySales($filters)
    {
        $tokDB = DB::connection('reportes');
        $filters['node'] = fnGetTokencashNode($filters['store']);
        $reportId = fnGenerateReportId($filters);
        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember('history-sales-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $tokDB->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('COUNT(VEN_ID) VENTAS, SUM(VEN_MONTO) MONTO_VENTA, VEN_DESTINO ESTABLECIMIENTO'))
            ->where('VEN_DESTINO', $filters['node'])
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('VEN_DESTINO')
            ->orderBy('VEN_DESTINO')
            ->chunk(10, function($sales) use(&$tmpRes) {
                foreach($sales as $sale)
                {
                    $tmpRes['sales'][$sale->ESTABLECIMIENTO] = [
                        'sales' => $sale->VENTAS,
                        'amount' => $sale->MONTO_VENTA,
                        'avg_sale' => $sale->MONTO_VENTA / $sale->VENTAS
                    ];
                }
            });

            return $tmpRes;
        });

        return $result;
    }

    function getDetailSales($filters)
    {
        $tokDB = DB::connection('reportes');
        $filters['node'] = fnGetTokencashNode($filters['store']);
        $reportId = fnGenerateReportId($filters);
        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember('datail-sales-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $totalSales = ['sales' => 0, 'ammount' => 0];
            $tokDB->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('DATE_FORMAT(VEN_FECHA_HORA, "%d/%m/%Y") DIA, COUNT(VEN_ID) VENTAS, SUM(VEN_MONTO) MONTO_VENTA'))
            ->whereIn('VEN_DESTINO', $filters['node'])
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->whereBetween('VEN_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('DIA')
            ->orderBy('DIA')
            ->chunk(10, function($sales) use(&$tmpRes, &$totalSales) {
                foreach($sales as $sale)
                {
                    $totalSales['sales'] += $sale->VENTAS;
                    $totalSales['ammount'] += $sale->MONTO_VENTA;
                    $tmpRes['sales'][$sale->DIA] = [
                        'date' => $sale->DIA,
                        'sales' => $sale->VENTAS,
                        'amount' => $sale->MONTO_VENTA
                    ];
                }
            });
            $tmpRes['totals'] = $totalSales;
            $tmpRes['totals']['average_sale'] = $totalSales['ammount'] / $totalSales['sales'];
            return $tmpRes;
        });

        return $result;
    }
}
