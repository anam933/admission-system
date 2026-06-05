<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display a user's profile with access control
     */
    public function show($id): View
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();

        // Access control logic
        $canView = false;

        // User can always view their own profile
        if ($currentUser->id == $user->id) {
            $canView = true;
        }
        // Admin can view anyone
        elseif ($currentUser->role === 'admin') {
            $canView = true;
        }
        // Manager can view employees
        elseif ($currentUser->role === 'manager' && $user->role === 'employee') {
            $canView = true;
        }

        if (!$canView) {
            abort(403, 'Unauthorized access to this profile');
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
