<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('can_access_dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('dashboard.index');
    }
}
