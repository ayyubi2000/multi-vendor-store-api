<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CsrfTokenLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // add csrf to all request and next handle for scramble dedoc
        $request->merge([
            'csrfToken' => csrf_token(),
        ]);

        Log::info('Processing request with method: '.$request->method().', CSRF token: '.csrf_token());

        return $next($request);
    }
}
