<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHTTPS
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // SEMENTARA DINONAKTIFKAN untuk troubleshooting 403 error
        return $next($request);
    }
    /*
        // Skip for local development
        if (app()->environment('local', 'testing')) {
            return $next($request);
        }

        // For Railway production, force HTTPS
        if (app()->environment('production') && !$request->isSecure()) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
        */
}
