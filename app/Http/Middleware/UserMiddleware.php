<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('user')->check()) {
            return redirect()->route('login')->with('error', 'Untuk Mengakses Fitur User Anda Harus Login Ke Session Users');
        }

        if (Auth::guard('user')->check()) {
            return $next($request);
        }
    }
}
