<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CouponReportController extends Controller
{
    public function printed()
    {
        return view('reports.coupons.printed');
    }

    public function redeemed()
    {
        return view('reports.coupons.redeemed');
    }

    public function lastPrinted()
    {
        return view('reports.coupons.last-printed');
    }

    public function printedRedeemed()
    {
        return view('reports.coupons.printed-redeemed');
    }

    public function detailRedeemed()
    {
        return view('reports.coupons.detail-redeemed');
    }

    public function printedRedeemedHistory()
    {
        return view('reports.coupons.redeemed-history');
    }
}
