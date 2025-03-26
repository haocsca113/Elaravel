<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Session;

class Impersonate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(session()->has('impersonate'))
        // {
        //     // dd(session()->all());
        //     Auth::onceUsingId(session('impersonate'));
        // }
        // return $next($request);

        if (session()->has('impersonate')) {
            $userId = session('impersonate');
            Auth::loginUsingId($userId);

            if (Auth::user()) {
                return $next($request);
            }

            // Nếu không tìm thấy user
            session()->forget('impersonate');
            return redirect('/login')->withErrors('User not found');
        }

        return $next($request);
    }
}
