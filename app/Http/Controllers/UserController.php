<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('can_access_users_module'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('user.index');
    }

    public function create()
    {
        abort_if(Gate::denies('can_access_create_users_module'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('user.create');
    }
}
