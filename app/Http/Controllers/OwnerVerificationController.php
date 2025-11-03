<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\OwnerVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerVerificationController extends Controller
{
    // buyer: show request form
    public function create()
    {
        $lots = Lot::with('block')->get(); 
        return view('owner-verification.create', compact('lots'));  
    }

    // buyer: submit request
    public function store(Request $request)
    {
        $request->validate([
            'lot_id' => 'nullable|exists:lots,id',
            'proof_document' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $path = $request->file('proof_document')->store('owner_proofs', 'public');

        OwnerVerification::create([
            'user_id' => Auth::id(),
            'lot_id' => $request->lot_id,
            'proof_document' => $path,
        ]);

        return redirect()->back()->with('success', 'Verification request submitted');
    }

    // admin: list all request
    public function index()
    {
        $requests = OwnerVerification::with('user', 'lot')->latest()->get();
        return view('owner-verification.index', compact('requests'));
    }

    // admin: approve request
    public function approve($id)
    {
        $request = OwnerVerification::findOrFail($id);
        $request->update(['status' => 'approved']);

        // update user role to owner
        $request->user->update(['role' => 'owner']);

        // assign lot owner_id if lot_id present
        if ($request->lot_id) {
            $request->lot->update(['owner_id' => $request->user->id]);
        }

        return redirect()->back()->with('success', 'Owner request approved.');
    }

    // admin: reject request
    public function reject($id)
    {
        $request = OwnerVerification::findOrFail($id);
        $request->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Owner request rejected.');
    }

}
