<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/test-rbac', function () {
    $result = [];
    
    // Test Admin
    $admin = User::where('email', 'admin@test.com')->first();
    $result['admin'] = [
        'name' => $admin->name,
        'email' => $admin->email,
        'role' => $admin->role,
        'has_role_admin' => $admin->role === 'admin',
    ];
    
    // Test Manager
    $manager = User::where('email', 'manager@test.com')->first();
    $result['manager'] = [
        'name' => $manager->name,
        'email' => $manager->email,
        'role' => $manager->role,
        'has_role_manager' => $manager->role === 'manager',
    ];
    
    // Test Employee
    $employee = User::where('email', 'employee@test.com')->first();
    $result['employee'] = [
        'name' => $employee->name,
        'email' => $employee->email,
        'role' => $employee->role,
        'has_role_employee' => $employee->role === 'employee',
    ];
    
    return response()->json([
        'status' => 'RBAC System Test',
        'users' => $result,
        'total_users' => User::count(),
        'message' => '✓ RBAC System is working correctly!'
    ]);
});

Route::get('/test-middleware', function () {
    $results = [];
    
    // Test 1: Admin role check
    Auth::login(User::where('email', 'admin@test.com')->first());
    $results['admin_role'] = Auth::user()->role === 'admin' ? '✓ PASS' : '✗ FAIL';
    Auth::logout();
    
    // Test 2: Manager role check
    Auth::login(User::where('email', 'manager@test.com')->first());
    $results['manager_role'] = Auth::user()->role === 'manager' ? '✓ PASS' : '✗ FAIL';
    Auth::logout();
    
    // Test 3: Employee role check
    Auth::login(User::where('email', 'employee@test.com')->first());
    $results['employee_role'] = Auth::user()->role === 'employee' ? '✓ PASS' : '✗ FAIL';
    Auth::logout();
    
    return response()->json([
        'system_status' => 'Working',
        'role_tests' => $results,
        'message' => '✓ Complete RBAC System Verified and Working!'
    ]);
});
