<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class KeuanganMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('user')->user()->roles == 'keuangan') {
            return $next($request);
        } else {
            Session::flash('error', 'Permission pada roles anda tidak di izinkan mengakses role keuangan');
            return Redirect::route('dashboard.utama');
        }
    }
}
