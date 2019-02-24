<?php

namespace SisVentas\Http\Middleware;

use Closure;

class CheckSession
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
          $codusu = session('key')['CodUsu'];
        if(!isset($codusu)){
            return redirect('login/index');
        }
        return $next($request);
    }
}
