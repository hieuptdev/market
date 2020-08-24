<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class SellerProduct
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
        $data = \App\Models\Product::where('seller_id', Auth::user()->id)->get();
        if($data->count() > 0){
            return $next($request);
        }
        return redirect()->route('index');
    }
}
