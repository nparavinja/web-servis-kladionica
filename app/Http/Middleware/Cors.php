<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // ovo je dodato zato sto se pojavljivala greska pri slanju zahteva sa frontenda:
    // https://stackoverflow.com/questions/20035101/why-doesn-t-postman-get-a-no-access-control-allow-origin-header-is-present-on
    // resio indijac na jutjubu:
    // https://www.youtube.com/watch?v=p3183c50YOQ


    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'PUT,POST,DELETE,GET,OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Accept,Authorization,Content-Type');
    }
}
