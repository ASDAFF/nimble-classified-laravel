<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
use DB;
class checkInstaller
{
/**
 * Handle an incoming request.
 *
 * @param  \Illuminate\Http\Request $request
 * @param  \Closure $next
 * @param  string|null $guard
 * @return mixed
 */
public function handle($request, Closure $next, $guard = null)
{
  if (DB::table('installer')->value('status') == 0 )
  {
    return response()->view('installer');
  }
  return $next($request);
}
}
