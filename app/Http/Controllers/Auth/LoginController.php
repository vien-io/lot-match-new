<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the custom login form.
     */
    public function showLoginForm()
    {
        return view('signin');
    }

    /**
     * Override failed login response.
     */
    public function sendFailedLoginResponse(Request $request)
    {
        return back()->with('error', 'Invalid email or password.');
    }

    /**
     * Override logout to always redirect to login page.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login page after logout
        return redirect('/login')->with('status', 'You have been logged out.');
    }
}
