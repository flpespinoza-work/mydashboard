<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceReportController extends Controller
{
    public function balance()
    {
        return view('reports.balance.balance');
    }
}
