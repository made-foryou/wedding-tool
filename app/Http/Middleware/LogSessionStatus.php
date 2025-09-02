<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogSessionStatus
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request):Response $next
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('Session Middleware: ID = '.$request->session()->getId());

        return $next($request);
    }
}
