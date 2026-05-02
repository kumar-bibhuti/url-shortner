<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->isSuperAdmin() || $user->isAdmin()) {
            return view('invitations.create');
        }
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Validate email
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);
        
        // Validate company_name only if SuperAdmin
        if ($user->isSuperAdmin()) {
            $request->validate([
                'company_name' => 'required|string|max:255',
            ]);
        }

        if ($user->isSuperAdmin()) {
            // SuperAdmin creates invitation - invited user will be admin
            $company = Company::firstOrCreate(
                ['name' => $request->company_name],
                ['name' => $request->company_name]
            );
            $invitedRole = 'admin';
        } elseif ($user->isAdmin()) {
            // Admin creates invitation - invited user will be member
            $company = $user->company;
            $invitedRole = 'member';
        } else {
            abort(403);
        }
        
        // Check if already invited to this company
        $existingInvitation = Invitation::where('email', $request->email)
            ->where('company_id', $company->id)
            ->where('status', 'pending')
            ->first();
        
        if ($existingInvitation) {
            return redirect()->back()->with('error', 'This user is already invited to this company.');
        }

        $token = Str::random(32);
        Invitation::create([
            'email' => $request->email,
            'company_id' => $company->id,
            'token' => $token,
            'status' => 'pending',
            'role' => $invitedRole,
        ]);
        return redirect()->back()->with('success', 'Invitation sent!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invitation $invitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invitation $invitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invitation $invitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invitation $invitation)
    {
        //
    }
}
