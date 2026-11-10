<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserManagementController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'asc')
            ->paginate(20);

        return view(
            'usermanagement.partials.user-table-rows',
            compact('users')
        );
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $users */
        $users = $query
            ->orderBy('id', 'asc')
            ->paginate(20)
            ->withQueryString();

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
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'required|in:admin,owner,buyer',
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'role' => 'nullable|in:admin,owner,buyer',
            'lot_ids' => 'nullable|array',
            'lot_ids.*' => 'exists:lots,id',
        ]);

        $user->update($request->only('username', 'first_name', 'last_name', 'email'));

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
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,owner,buyer',
            'lot_ids' => 'nullable|array',
            'lot_ids.*' => 'required|integer|distinct|exists:lots,id',
        ]);

        $newRole = $validated['role'];
        $lotIds = $validated['lot_ids'] ?? [];

        DB::transaction(function () use ($user, $newRole, $lotIds) {

            $oldRole = $user->role;

            $user->update([
                'role' => $newRole,
            ]);

            // If the user is no longer an owner, release all assigned lots.
            if ($newRole !== 'owner') {
                Lot::where('owner_id', $user->id)
                    ->update(['owner_id' => null]);

                return;
            }

            // Lock selected lots to prevent conflicting assignments.
            $lots = Lot::whereIn('id', $lotIds)
                ->lockForUpdate()
                ->get();

            // Prevent assigning lots that belong to another owner.
            $conflictingLot = $lots->first(
                fn($lot) => $lot->owner_id !== null
                    && $lot->owner_id != $user->id
            );

            if ($conflictingLot) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'lot_ids' => "Lot {$conflictingLot->name} is already assigned to another owner.",
                ]);
            }

            // Remove assignments that were deselected.
            Lot::where('owner_id', $user->id)
                ->whereNotIn('id', $lotIds)
                ->update(['owner_id' => null]);

            // Assign the selected lots to this owner.
            if (!empty($lotIds)) {
                Lot::whereIn('id', $lotIds)
                    ->update(['owner_id' => $user->id]);
            }
        });

        return response()->json([
            'message' => 'User role and lot assignments updated successfully.',
            'role' => $user->role,
            'assigned_lot_ids' => Lot::where('owner_id', $user->id)
                ->pluck('id'),
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('usermanagement.index')->with('success', 'User deleted successfully');
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
        ]);

        $user->update($request->only('name', 'username', 'email'));
        return redirect()->route('profile')->with('success', 'Profile updated.');
    }


}
