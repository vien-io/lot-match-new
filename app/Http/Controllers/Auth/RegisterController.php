<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/signin';

    /**
     * show signup pge
     *
     * @return \Illuminate\View\View
     */

    public function showRegistrationForm()
    {
        return view('signup');
    }

 /**
     * Handle user registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


   

    // handles register submission
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'buyer',
        ]);

        $user->sendEmailVerificationNotification();
        Auth::login($user);
        // redirect user to login
        return redirect()->route('dashboard')->with('success', 'Account created successfully! You may now sign in.');
    }
}
