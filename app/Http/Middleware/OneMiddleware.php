<?php

namespace App\Http\Middleware;

use App\Services\OptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OneMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route()->uri() == 'register' && \Str::lower($request->method()) == 'post') {
            $options = (new OptionService())->autoload();

            if (!$options['users_can_register']) {
                abort(403, '说不可以就是不可以 (￢︿̫̿￢☆)');
            }
        }

        return $next($request);
    }
}
