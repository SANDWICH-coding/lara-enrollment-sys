<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('lastActivity')) {
            session(['lastActivity' => now()]);
        }

        if (now()->diffInMinutes(session('lastActivity')) > config('session.lifetime')) {
            session()->flush(); // Clears the session
            return redirect()->route('login')->with('message', 'Session expired. Please log in again.');
        }

        session(['lastActivity' => now()]);
        return $next($request);
    }
}
