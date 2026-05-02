<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Invitation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request)
    {
        $token = $request->query('token');
        $invitation = null;
        if ($token) {
            $invitation = Invitation::where('token', $token)->where('status', 'pending')->first();
        }
        return view('auth.register', compact('invitation'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $invitation = null;
        if ($request->email) {
            $invitation = Invitation::where('email', $request->email)->first();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $invitation ? $invitation->role : 'member',
            'company_id' => $invitation ? $invitation->company_id : null,
        ]);

        if ($invitation) {
            $invitation->update(['status' => 'accepted']);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('url.index', absolute: false));
    }
}
