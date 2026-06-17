<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (SINGLE DASHBOARD SYSTEM)
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $manager = Auth::user();
        $employees = \App\Models\User::where('role', 'employee')
            ->where('institute_id', $manager->institute_id)
            ->get();

        return view('manager.dashboard', [
            'manager' => $manager,
            'employees' => $employees,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT (OPTIONAL)
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        return back()->with('info', 'Manager edit feature can be added here');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE (OPTIONAL)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        return back()->with('info', 'Manager update feature can be added here');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE (OPTIONAL)
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        return back()->with('info', 'Manager delete feature can be added here');
    }
}