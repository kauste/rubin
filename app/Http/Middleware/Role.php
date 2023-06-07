<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$role){
        dump($role);
        $userRole = $request->user()?->role ?? 0;
        if(count($role) === 2 && in_array('guest', $role) && in_array('user', $role)){
            if($userRole > 1){
                abort(401);
            } 
        }
        elseif(count($role) === 1 && in_array('user', $role)){
            if($userRole !== 1){
                abort(401);
            } 
        }
        elseif(count($role) === 1 && in_array('admin', $role)){
            if($userRole !== 10){ 
                abort(401);
            } 
        }

        return $next($request);
    }
}
