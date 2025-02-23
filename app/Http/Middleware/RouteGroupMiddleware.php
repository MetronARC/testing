<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class RouteGroupMiddleware
{
    public function handle($request, Closure $next)
    {
        $currentRoute = Route::current();
        $routeGroup = null;

        if ($currentRoute) {
            $routeAction = $currentRoute->getAction();

            if (isset($routeAction['as'])) {
                $routeName = $routeAction['as'];
                $routeGroup = explode('.', $routeName)[0];
            }
        }

        view()->share('routeGroup', $routeGroup);

        return $next($request);
    }
}