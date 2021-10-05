<?php

namespace App\Http\Controllers;

use App\Exports\DetailRedeemedCouponsExport;
use App\Exports\PrintedCouponsExport;
use App\Exports\PrintedRedeemedCouponsExport;
use App\Exports\RedeemedCouponsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class CouponReportController extends Controller
{
    public function printed()
    {
        abort_if(Gate::denies('can_access_printed_coupons_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.coupons.printed');
    }

    public function redeemed()
    {
        abort_if(Gate::denies('can_access_redeemed_coupons_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.coupons.redeemed');
    }

    public function lastPrinted()
    {
        abort_if(Gate::denies('can_access_last_coupon_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.coupons.last-printed');
    }

    public function printedRedeemed()
    {
        abort_if(Gate::denies('can_access_printed_redeemed_coupons_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.coupons.printed-redeemed');
    }

    public function detailRedeemed()
    {
        abort_if(Gate::denies('can_access_detail_redeemed_coupons_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.coupons.detail-redeemed');
    }

    public function printedRedeemedHistory()
    {
        abort_if(Gate::denies('can_access_printed_redeemed_history_coupons_report'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('reports.coupons.redeemed-history');
    }

    public function downloadPrinted($data)
    {
        $data = Crypt::decrypt($data);
        $info = Cache::get($data['report_id']);
        return (new PrintedCouponsExport(collect($info['coupons']), $data['report_data']))->download('reporte_cupones_impresos.xlsx');
    }

    public function downloadRedeemed($data)
    {
        $data = Crypt::decrypt($data);
        $info = Cache::get($data['report_id']);
        return (new RedeemedCouponsExport(collect($info['coupons']), $data['report_data']))->download('reporte_cupones_canjeados.xlsx');
    }

    public function downloadPrintedRedeemed($data)
    {
        $data = Crypt::decrypt($data);
        $info = Cache::get($data['report_id']);
        return (new PrintedRedeemedCouponsExport(collect($info['coupons']), $data['report_data']))->download('reporte_cupones_impresos_canjeados.xlsx');
    }

    public function downloadDetailRedeemed($data)
    {
        $data = Crypt::decrypt($data);
        $info = Cache::get($data['report_id']);
        return (new DetailRedeemedCouponsExport(collect($info['coupons']), $data['report_data']))->download('reporte_cupones_canjeados_detalle.xlsx');
    }
}
