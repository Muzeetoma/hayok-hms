<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class HealthWorker
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
          return redirect()->route('patient');
      }
      if(Auth::user()->role == 'healthworker'){
        return $next($request);
      }else{
        return redirect()->route('home');
      }

        
    }
}
