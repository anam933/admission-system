<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /*
    | USERS LIST
    */
    public function index()
    {
        $user = auth()->user();

        $users = $user->role === 'manager'
            ? User::where('role', 'employee')
                ->where('institute_id', $user->institute_id)
                ->get()
            : User::with('institute')->get();

        return view('admin.users', compact('users'));
    }

    /*
    | CREATE FORM
    */
    public function create()
    {
        $institutes = Institute::all();
        return view('admin.create', compact('institutes'));
    }

    /*
    | STORE USER (FIXED ROLE LOGIC)
    */
    public function store(Request $request)
    {
        $authUser = auth()->user();
        $isManager = $authUser->role === 'manager';

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,manager,employee',
            'institute_id' => 'nullable|exists:institutes,id',
        ]);

        // 🔒 MANAGER RESTRICTION
        if ($isManager) {
            if ($request->role !== 'employee') {
                return back()->with('error', 'Manager can only create employee');
            }
        }

        // 🏢 Institute handling
        $instituteId = $isManager
            ? $authUser->institute_id
            : $request->institute_id;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'institute_id' => $instituteId,
            'created_by' => $authUser->id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    /*
    | EDIT USER
    */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->role === 'manager') {
            if ($user->role !== 'employee' || $user->institute_id !== auth()->user()->institute_id) {
                return back()->with('error', 'Not allowed');
            }
        }

        $institutes = auth()->user()->role === 'admin'
            ? Institute::all()
            : collect();

        return view('admin.edit', compact('user', 'institutes'));
    }

    /*
    | UPDATE USER
    */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $authUser = auth()->user();
        $isManager = $authUser->role === 'manager';

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,manager,employee',
            'institute_id' => 'nullable|exists:institutes,id',
        ]);

        if ($isManager && $request->role !== 'employee') {
            return back()->with('error', 'Manager can only assign employee role');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if (!$isManager) {
            $data['institute_id'] = $request->institute_id;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    /*
    | DELETE USER
    */
    public function destroy($id)
    {
        if ($id == auth()->id()) {
            return back()->with('error', 'You cannot delete yourself');
        }

        $user = User::findOrFail($id);

        if (auth()->user()->role === 'manager') {
            if ($user->role !== 'employee' || $user->institute_id !== auth()->user()->institute_id) {
                return back()->with('error', 'Not allowed');
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}