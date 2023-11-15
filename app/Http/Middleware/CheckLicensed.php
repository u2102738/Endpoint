<?php

namespace App\Http\Middleware;

use App\Models\AllSoftware;
use Closure;
use Illuminate\Http\Request;

class CheckLicensed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $softwareId = $request->route('id');
        $software = AllSoftware::find($softwareId);

        if (!$software || $software->type !== 1) {
            return redirect()->route('pages.404', 'en');
        }

        return $next($request);
    }
}
