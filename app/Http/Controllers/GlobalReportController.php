<?php

namespace App\Http\Controllers;

use App\Exports\GlobalsRedeemsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

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

    public function downloadRedeems($data)
    {
        $data = Crypt::decrypt($data);
        dd($data);
        $info = Cache::get($data['report_id']);
        return (new GlobalsRedeemsExport($data['days'], collect($info['redeems']), $data['report_data']))->download('reporte_global_canjes_diarios.xlsx');
    }

    public function downloadRegisters($data)
    {
        $data = Crypt::decrypt($data);
    }
}
