<?php

namespace App\Http\Middleware;

use Closure;

class Checkip
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
        $redirect = true;
        if ( $request->ip() !== '176.221.219.254') {
            $redirect = false;
        }

        if($redirect) {
            return redirect('http://uc.antidze.com');
        }

        return $next($request);
    }
}
