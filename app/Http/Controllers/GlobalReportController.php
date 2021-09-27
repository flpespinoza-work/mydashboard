<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class GlobalReportController extends Controller
{
    public function redeems()
    {
        abort_if(Gate::denies('can_access_globals_redeems_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.globals.redeems');
    }

    public function registers()
    {
        abort_if(Gate::denies('can_access_global_users_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.globals.registers');
    }
}
