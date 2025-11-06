<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // validate the request
        $data = $request->validate([
            'show_owner_tags' => 'required|boolean',
        ]);

        $settings = UserSetting::updateOrCreate(
            ['user_id' => $user->id],  
            ['show_owner_tags' => $data['show_owner_tags']]
        );

        return response()->json([
            'success' => true,
            'show_owner_tags' => $settings->show_owner_tags
        ]);
    }

    public function get()
    {
        $user = Auth::user();
        $settings = UserSetting::firstOrCreate(
            ['user_id' => $user->id],
            ['show_owner_tags' => true]
        );

        return response()->json([
            'show_owner_tags' => (bool) $settings->show_owner_tags
        ]);
    }
}
