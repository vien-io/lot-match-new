<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('usermanagement.index', compact('users'));
    }

    public function create()
    {
        return view('usermanagement.create');
    }


    public function store(Request $request)
    {
        Log::info('store function reached!!');
        
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users',
                'password' => 'required|string|min:6', 
            ]);

            Log::info('Validation passed', $validated);

            // hash password before saving
            $validated['password'] = bcrypt($validated['password']);

            // create user
            $user = User::create($validated);
            Log::info('New user created', $user->toArray());

        } catch (ValidationException $e) {
            Log::warning('Validation failed', $e->errors());
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Something went wrong while creating the user.')
                ->withInput();
        }

        return redirect()
            ->route('usermanagement.index')
            ->with('success', 'User created successfully.');
    }





    public function edit(User $user)
    {
        return view('usermanagement.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
        ]);

        $user->update($request->only('username', 'name', 'email'));

        return redirect()->route('usermanagement.index')->with('success', 'User updated successfully.');
    }

    public function destroy (User $user)
    {
        $user->delete();
        return redirect()->route('usermanagement.index')->with('success', 'User deleted successfully');
    }

}
