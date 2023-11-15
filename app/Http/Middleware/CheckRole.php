<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        $user = $request->user();
        if ($user->role_id != $role) {
            return redirect()->route('pages.403', 'en');
        }

        return $next($request);
    }
}
