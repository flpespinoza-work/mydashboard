<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalReportController extends Controller
{
    public function redeems()
    {
        return view('reports.globals.redeems');
    }

    public function registers()
    {
        return view('reports.globals.registers');
    }
}
