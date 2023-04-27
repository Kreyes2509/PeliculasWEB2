<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class codesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clientIP = $request->ip();

        $vpn = ['192.168.0.1','192.168.0.2','192.168.0.3','192.168.0.4',
        '192.168.0.5','192.168.0.6','192.168.0.7','192.168.0.8',
        '192.168.0.9','192.168.0.10','192.168.0.11','192.168.0.12'];

        if(auth()->check() && auth()->user()->rol_id  == 1 && auth()->user()->status  == 1)
        {
            foreach($vpn as $vpnip)
            {
                if($clientIP == $vpnip)
                {
                    return $next($request);
                }
            }
        }
        if(auth()->check() && auth()->user()->rol_id  == 2 && auth()->user()->status  == 1)
        {
            return $next($request);
        }
        return redirect('/');
    }
}
