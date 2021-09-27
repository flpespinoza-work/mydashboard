<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

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
}
