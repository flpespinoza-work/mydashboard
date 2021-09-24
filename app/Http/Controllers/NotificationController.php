<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notification.index');
    }

    public function stats($campaign)
    {
        return view('notification.stats', ['campaign' => $campaign]);
    }
}
