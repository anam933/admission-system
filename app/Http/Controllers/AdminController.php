<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $users = User::all();

        return view('admin.dashboard', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE USER
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'User created successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT USER
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.edit', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE USER
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Only admin can change role
        if (auth()->user()->role === 'admin') {
            $data['role'] = $request->role;
        }

        $user->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'User updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE USER
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        // prevent self delete
        if ($id == auth()->id()) {
            return back()->with('error', 'You cannot delete yourself');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'User deleted successfully');
    }
}