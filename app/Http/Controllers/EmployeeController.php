<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $employee = Auth::user();

        return view('employee.dashboard', compact('employee'));
    }
}