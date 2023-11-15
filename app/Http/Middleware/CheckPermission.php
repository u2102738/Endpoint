<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!$request->user()->hasPermission($permission)) {
            return redirect()->route('pages.403','en');
        }

        return $next($request);
    }
}

