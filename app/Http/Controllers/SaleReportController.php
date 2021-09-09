<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    public function detail()
    {
        return view('reports.sales.detail');
    }

    public function history()
    {
        return view('reports.sales.history');
    }

    public function sales()
    {
        return view('reports.sales.sales');
    }
}
