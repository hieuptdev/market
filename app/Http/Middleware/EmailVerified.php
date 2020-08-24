<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class EmailVerified
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
        if(Auth::check() && !Auth::user()->email_verified_at){
            Auth::logout();
       		return redirect()->route('index');
        }
        return $next($request);
    }
}
