<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function dashboard()
{
    $manager = Auth::user();

    $employees = User::where('role', 'employee')->get();

    return view('manager.dashboard', compact('manager', 'employees'));
}
}