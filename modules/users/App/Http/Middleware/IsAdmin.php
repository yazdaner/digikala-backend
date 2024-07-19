<?php

namespace Modules\users\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $check = runEvent('access:admin-check',[
            'uri' => $request->route()->uri
        ],true);

        if(Auth::user()->role === 'admin' || $check){
            return $next($request);
        }else{
            return abort(401);
        }
    }
}
