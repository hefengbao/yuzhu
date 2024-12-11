<?php

namespace App\Http\Middleware;

use App\Services\OptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanRegisterMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getRequestUri() == '/admin/register' && \Str::lower($request->method()) == 'get') {
            $options = (new OptionService())->autoload();

            if (!$options['users_can_register']) {
                abort(403, '说不可以就是不可以(。・・)ノ');
            }
        }

        return $next($request);
    }
}
