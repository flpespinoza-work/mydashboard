<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('can_access_groups_module'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('group.index');
    }
}
