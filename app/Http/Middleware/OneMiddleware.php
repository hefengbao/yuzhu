<?php

namespace App\Http\Middleware;

use App\Services\OptionService;
use Closure;
use Illuminate\Http\Request;

class OneMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
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
