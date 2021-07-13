<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class Patient
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
        
      if(!Auth::check()){
        return redirect()->route('login');
    }
    if(Auth::user()->role == 'patient'){
        
        return $next($request);
    }
    if(Auth::user()->role == 'healthworker'){
        return redirect()->route('healthworker');
    }else{
        return redirect()->route('home');
      }


    }
}
