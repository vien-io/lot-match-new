<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $users */
        $users = $query->paginate(20)->withQueryString();

        // Load all lots with their blocks
        $allLots = Lot::with('block')->get()->map(function ($l) {
            return [
                'id' => $l->id,
                'name' => $l->name,
                'block' => $l->block->name,
                'owner_id' => $l->owner_id,
            ];
        });

        return view('usermanagement.index', compact('users', 'allLots'));
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
            'role' => 'nullable|in:admin,owner,buyer',
            'lot_ids' => 'nullable|array',
            'lot_ids.*' => 'exists:lots,id',
        ]);

        $user->update($request->only('username', 'name', 'email'));

        $newRole = $request->role;

        // update role
        if ($request->filled('role')) {
            $user->update([
                'role' => $newRole,
                'email_verified_at' => ($newRole === 'owner' || $newRole === 'admin') ? now() : null,
            ]);
        }

        if ($newRole === 'owner') {
            Lot::where('owner_id', $user->id)->update(['owner_id' => null]);
            if ($request->filled('lot_ids')) {
                Lot::whereIn('id', $request->lot_ids)->update(['owner_id' => $user->id]);
            }
        } else {
            Lot::where('owner_id', $user->id)->update(['owner_id' => null]);
        }

        return redirect()->route('usermanagement.index')->with('success', 'User updated successfully.');
    }

    public function destroy (User $user)
    {
        $user->delete();
        return redirect()->route('usermanagement.index')->with('success', 'User deleted successfully');
    }

}
