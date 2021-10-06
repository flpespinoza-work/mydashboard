<?php

namespace App\Http\Controllers;

use App\Exports\DetailSalesExport;
use App\Exports\SalesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class SaleReportController extends Controller
{
    public function detail()
    {
        abort_if(Gate::denies('can_access_detail_sales_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.sales.detail');
    }

    public function history()
    {
        abort_if(Gate::denies('can_access_history_sales_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.sales.history');
    }

    public function sales()
    {
        abort_if(Gate::denies('can_access_sales_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.sales.sales');
    }

    public function downloadSales($data)
    {
        $data = Crypt::decrypt($data);
        $info = Cache::get($data['report_id']);
        return (new SalesExport(collect(array_reverse($info['sales'])), $data['report_data']))->download('reporte_ventas.xlsx');
    }

    public function downloadDetailSales($data)
    {
        $data = Crypt::decrypt($data);
        $info = Cache::get($data['report_id']);
        return (new DetailSalesExport(collect(array_reverse($info['sales'])), $data['report_data']))->download('reporte_ventas_detalle.xlsx');
    }
}
