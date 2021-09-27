<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

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
}
