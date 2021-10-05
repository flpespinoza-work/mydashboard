<?php

namespace App\Traits\Reports;
use Illuminate\Support\Facades\DB;

trait Sales
{
    function getDetailSales($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportId = 'sales-report' . fnGenerateReportId($filters);
        $filters['node'] = fnGetTokencashNode($filters['store']);
        $filters['giftcard'] = fnGetGiftcardFull($filters['store']);
        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember($reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $totalSales = ['sales' => 0, 'amount' => 0];

            $tokDB->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('NOD_USU_NODO, VEN_ID, DATE_FORMAT(VEN_FECHA_HORA, "%d/%m/%Y %H:%i:%s") VEN_FECHA_HORA, VEN_MONTO MONTO_VENTA'))
            ->where('VEN_DESTINO', $filters['node'])
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->whereBetween('VEN_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('VEN_ID')
            ->orderBy('VEN_FECHA_HORA')
            ->orderBy('NOD_USU_NODO')
            ->chunk(1000, function($sales) use(&$tmpRes, &$totalSales) {
                foreach($sales as $sale)
                {
                    $totalSales['sales'] += 1;
                    $totalSales['amount'] += $sale->MONTO_VENTA;
                    $tmpRes['sales'][$sale->VEN_FECHA_HORA] = [
                        'date' => $sale->VEN_FECHA_HORA,
                        'user' => $sale->NOD_USU_NODO,
                        'amount' => $sale->MONTO_VENTA
                    ];
                }
            });

            if(count($tmpRes))
            {
                uksort($tmpRes['sales'], function($a, $b){
                    return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));
                });

                $tmpRes['totals'] = $totalSales;
                $tmpRes['totals']['average_sale'] = $totalSales['amount'] / $totalSales['sales'];
            }

            return $tmpRes;
        });

        if(isset($result['sales']))
            $result['report_id'] = $reportId;

        return $result;
    }

    function getHistorySales($filters) //Revisar si es posible solo traer desde el 2020
    {
        $tokDB = DB::connection('reportes');
        $rememberReport = fnRememberReportTime(date('Y-m-d'));
        $filters['node'] = fnGetTokencashNode($filters['store']);
        $reportId = fnGenerateReportId($filters);
        $result = cache()->remember('history-sales-report' . $reportId, $rememberReport, function() use($tokDB, $filters){
            return $tokDB->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('COUNT(1) sales, SUM(VEN_MONTO) amount'))
            ->where('VEN_DESTINO', $filters['node'])
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->get()
            ->toArray();
        });

        if(count($result))
        {
            return ['sales' => $result[0]->sales, 'amount' => $result[0]->amount ];
        }

        return ['sales' => '0', 'amount' => '0.00' ];
    }

    function getSales($filters)
    {
        $tokDB = DB::connection('reportes');
        $reportId = 'datail-sales-report' . fnGenerateReportId($filters);
        $filters['node'] = fnGetTokencashNode($filters['store']);

        $rememberReport = fnRememberReportTime($filters['final_date']);

        $result = cache()->remember($reportId, $rememberReport, function() use($tokDB, $filters){
            $tmpRes = [];
            $totalSales = ['sales' => 0, 'amount' => 0];
            $tokDB->table('doc_dbm_ventas')
            ->join('cat_dbm_nodos_usuarios', 'doc_dbm_ventas.VEN_NODO', '=', 'cat_dbm_nodos_usuarios.NOD_USU_NODO')
            ->select(DB::raw('DATE_FORMAT(VEN_FECHA_HORA, "%d/%m/%Y") DIA, COUNT(VEN_ID) VENTAS, SUM(VEN_MONTO) MONTO_VENTA'))
            ->where('VEN_DESTINO', $filters['node'])
            ->where('VEN_ESTADO', '=', 'VIGENTE')
            ->whereBetween('VEN_FECHA_HORA', [$filters['initial_date'] . ' 00:00:00', $filters['final_date'] . ' 23:59:59'])
            ->whereRaw("(BINARY NOD_USU_CERTIFICADO REGEXP '[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]+[o][CEFIKLNQSTWXYbcdgkmprsuvy24579]+[a-zA-Z0-9]' OR NOD_USU_CERTIFICADO = '')")
            ->groupBy('DIA')
            ->orderBy('DIA')
            ->chunk(1000, function($sales) use(&$tmpRes, &$totalSales) {
                foreach($sales as $sale)
                {
                    $totalSales['sales'] += $sale->VENTAS;
                    $totalSales['amount'] += $sale->MONTO_VENTA;
                    $tmpRes['sales'][$sale->DIA] = [
                        'date' => $sale->DIA,
                        'sales' => $sale->VENTAS,
                        'amount' => $sale->MONTO_VENTA
                    ];
                }
            });

            if($totalSales['sales'] > 0)
            {
                uksort($tmpRes['sales'], function($a, $b){
                    return strtotime(str_replace('/', '-', $a)) - strtotime(str_replace('/', '-', $b));
                });

                $tmpRes['totals'] = $totalSales;
                $tmpRes['totals']['average_sale'] = $totalSales['amount'] / $totalSales['sales'];
            }

            return $tmpRes;
        });

        if(isset($result['sales']))
            $result['report_id'] = $reportId;

        return $result;
    }
}
