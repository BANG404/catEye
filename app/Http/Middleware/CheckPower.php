<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPower
{
    /**
     * Handle an incoming request.
     * 查看是否有权限
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        $user= $request->session()->get('user');
        if($user['role']==1){
            return $next($request);
        }else{
            return response()->json(['data'=>null,'code'=>401 , 'msg'=>'没有权限']);
        }
    }
}
