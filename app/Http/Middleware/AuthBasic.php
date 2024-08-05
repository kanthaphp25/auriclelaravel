<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthBasic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		//dd($request);
		$credentials = [
        'email' => $request->header('php-auth-user'),
        'password' => $request->header('php-auth-pw'),
    ];
		if(Auth::attempt($credentials))
		{
			return $next($request);
		}
		abort(401);
    }
}
