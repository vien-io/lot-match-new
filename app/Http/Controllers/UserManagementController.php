<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6', 
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('usermanagement.index')->with('success', 'User created successfully.');
    }



    public function edit(User $user)
    {
        return view('usermanagement.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('usermanagement.index')->with('success', 'User updated successfully.');
    }

    public function destroy (User $user)
    {
        $user->delete();
        return redirect()->route('usermanagement.index')->with('success', 'User deleted successfully');
    }

}
