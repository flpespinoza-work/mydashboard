<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserReportController extends Controller
{
    public function new()
    {
        return view('reports.users.new');
    }

    public function history()
    {
        return view('reports.users.history');
    }
}
