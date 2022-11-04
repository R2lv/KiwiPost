<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;

class App
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        Config::set('app.locale', app('isGeorgian') ? 'ka' : 'en');



        if($request->hasCookie("lang")) {
            \App::setLocale($request->cookie('lang'));
            Config::set('defaults.parcels', trans('defaults.parcels'));
            $res = $next($request);
        } else {
            \App::setLocale(config('app.locale'));
            $cookie = cookie('lang', config('app.locale'), 0, null, null, false, false);
            Config::set('defaults.parcels', trans('defaults.parcels'));
            $res = $next($request)->withCookie($cookie);
        }




        return $res;
    }
}
