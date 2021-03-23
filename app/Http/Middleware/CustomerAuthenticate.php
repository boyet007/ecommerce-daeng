<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CustomerAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //JADI KITA CEK, JIKA GUARD CUSTOMER BELUM LOGIN
        if (!Auth::guard('customer')->check()) {
            //MAKA REDIRECT KE HALAMAN LOGIN
            return redirect(route('customer.login'));
        }
        //JIKA SUDAH MAKA REQUEST YANG DIMINTA AKAN DISEDIAKAN
        return $next($request);
    }
}
