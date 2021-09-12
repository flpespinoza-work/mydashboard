<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check())
        {
            $expiresAt = Carbon::now()->addMinutes(5);
            Cache::put('user-online-' . auth()->user()->id, true, $expiresAt);
        }

        return $next($request);
    }
}
