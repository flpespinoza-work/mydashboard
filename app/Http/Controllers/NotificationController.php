<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('can_access_campaigns'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('notification.index');
    }

    public function stats($campaign)
    {
        return view('notification.stats', ['campaign' => $campaign]);
    }

    public function create()
    {
        return view('notifications.create');
    }
}
