<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use App\Exports\UsersExport;
use App\Exports\UsersHistoryExport;
use Illuminate\Support\Facades\Cache;

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

    public function activity()
    {
        abort_if(Gate::denies('can_access_activity_users_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('reports.users.activity');
    }

    public function downloadNew($data)
    {
        $data = Crypt::decrypt($data);
        $info = Cache::get($data['report_id']);
        return (new UsersExport(collect(array_reverse($info['data'])), $data['report_data']))->download('reporte_nuevos_usuarios.xlsx');
    }

    public function downloadHistory($data)
    {
        $data = Crypt::decrypt($data);
        return (new UsersHistoryExport(collect($data['data']), $data['report_data']))->download('reporte_acumulado_usuarios.xlsx');
    }
}
