<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class DebugController extends Controller
{
    public function verificationLink()
    {
        $user = Auth::user();
    if (!$user) {
        return 'No authenticated user';
    }
    $directLink = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    return view('debug.verification-link', [
        'directLink' => $directLink,
        'scheme' => request()->getScheme(),
        'host' => request()->getHost(),
        'app_env' => app()->environment(),
        'app_key_set' => config('app.key') ? true : false,
    ]);

    }
}
