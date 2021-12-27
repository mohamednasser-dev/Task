<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
       //manual login
        if (auth::guard('web')->attempt(['email' => Request('email'), 'password' => Request('password')], null)) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }elseif (auth::guard('supervisor')->attempt(['email' => Request('email'), 'password' => Request('password')], null)){
            if(auth::guard('supervisor')->user()->status == 'Block'){
                auth::guard('supervisor')->logout();
                Alert::warning('warning', 'you are Blocked , contact manager to unBlock your account..');
                return redirect()->back();
            }
            return redirect(route('supervisor.home'));
        }else{
            Alert::error('invalid', 'email or password is invalid');
            return redirect()->back();
        }
       //system functions
//        $request->authenticate();
//        $request->session()->regenerate();
//        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        if(Auth::guard('web')->check()){
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }elseif(Auth::guard('supervisor')->check()){
            Auth::guard('supervisor')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }
    }
}
