<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request):Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->is('api/*')) {
            $request->headers->set('accept', 'application/json');
        }

        return $next($request);
    }
}
