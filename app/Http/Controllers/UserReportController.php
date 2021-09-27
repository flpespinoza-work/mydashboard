<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class UserReportController extends Controller
{
    public function new()
    {
        abort_if(Gate::denies('can_access_new_users_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.users.new');
    }

    public function history()
    {
        abort_if(Gate::denies('can_access_history_users_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.users.history');
    }
}
