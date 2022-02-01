<?php
namespace App\Http\Middleware;
use Closure;

use Auth;
class checkAdmin
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::User()->type != 'adm')
        {
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }
}
