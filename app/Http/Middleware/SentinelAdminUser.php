<?php
namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelAdminUser
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
        if ( ! is_admin() ) {
            // return redirect('login');
            return abort(404);
        }
        return $next($request);
    }
}