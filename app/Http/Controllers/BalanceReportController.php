<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class BalanceReportController extends Controller
{
    public function balance()
    {
        abort_if(Gate::denies('can_access_balance_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.balance.balance');
    }
}
