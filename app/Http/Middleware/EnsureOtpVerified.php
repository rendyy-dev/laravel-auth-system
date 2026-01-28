<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $purpose)
    {

        if (auth()->user()?->role === 'super_admin') {
            return $next($request);
        }

        if (session('otp_verified') !== $purpose) {
            abort(403);
        }

        return $next($request);
    }

}
