<?php
  
namespace App\Http\Middleware;
  
use Closure;
   
class IsJobseeker
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
        if(auth()->user()->role == 1 || auth()->user()->role == 0){
            return $next($request);
        }
   
        return redirect('/')->with('error',"You don't have admin access.");
    }
}