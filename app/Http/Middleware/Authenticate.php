<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {

//            if (\Auth::guard('web')->check()) {
//                return redirect()->route('admin_login');
//            } else if (\Auth::guard('supervisor')->check()) {
//                return redirect()->route('bank_login');
//            }
            return route('login');
        }
    }
}
