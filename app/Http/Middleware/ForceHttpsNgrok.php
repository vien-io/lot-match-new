<?php

namespace App\Http\Middleware;

use Closure;

class ForceHttpsNgrok
{
    public function handle($request, Closure $next)
    {
        if (str_contains($request->getHost(), 'ngrok-free.dev')) {
            $request->server->set('HTTPS', 'on');
            $_SERVER['HTTPS'] = 'on';
        }

        return $next($request);
    }
}