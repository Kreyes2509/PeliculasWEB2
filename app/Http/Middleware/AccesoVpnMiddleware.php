<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccesoVpnMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientIP = $request->ip();

        $vpn = ['172.16.0.1','172.16.0.2','172.16.0.3','172.16.0.4',
                '172.16.0.5','172.16.0.6','172.16.0.7','172.16.0.8',
                '172.16.0.9','172.16.0.10','172.16.0.11','172.16.0.12'];

        if($clientIP == $vpn && auth()->check() && auth()->user()->status_code && auth()->user()->status_qr && auth()->user()->rol_id == 1 && auth()->user()->status  == 1)
        {
            return $next($request);
        }
        if(auth()->check() && auth()->user()->rol_id  == 2 && auth()->user()->status  == 1)
        {
            return $next($request);
        }
        if(auth()->check() && auth()->user()->rol_id == 3 && auth()->user()->status  == 1)
        {
            return $next($request);
        }

        return redirect('/denegado');
    }
}
