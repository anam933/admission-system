<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Delete existing test users
User::where('email', 'like', '%@test.com')->delete();

// Create test users
User::create([
    'name' => 'Admin User',
    'email' => 'admin@test.com',
    'password' => Hash::make('password123'),
    'role' => 'admin',
]);

User::create([
    'name' => 'Manager User',
    'email' => 'manager@test.com',
    'password' => Hash::make('password123'),
    'role' => 'manager',
]);

User::create([
    'name' => 'Employee User',
    'email' => 'employee@test.com',
    'password' => Hash::make('password123'),
    'role' => 'employee',
]);

echo "✓ Test users created successfully!\n";
echo "✓ Admin: admin@test.com\n";
echo "✓ Manager: manager@test.com\n";
echo "✓ Employee: employee@test.com\n";
echo "✓ Password: password123\n";
