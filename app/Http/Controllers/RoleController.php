<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    function index()
    {
        abort_if(Gate::denies('can_access_roles_module'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('role.index');
    }
}
