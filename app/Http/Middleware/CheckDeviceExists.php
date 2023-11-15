<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;

class CheckDeviceExists
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
        $deviceId = $request->route('id');

        // Check if the device exists in the database
        if (!Device::where('id', $deviceId)->exists()) {
            // Device does not exist, redirect to invalid page
            return redirect()->route('pages.404','en');
        }

        return $next($request);
    }
}
