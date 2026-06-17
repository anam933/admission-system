<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBAC System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-600">
        RBAC System
    </h1>
    <div class="flex items-center gap-4">
        <span class="font-semibold text-gray-700">
            {{ auth()->user()->name }}
        </span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                Logout
            </button>
        </form>
    </div>
</nav>

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 min-h-screen bg-white shadow p-4">
        <ul class="space-y-3 font-medium text-gray-600">

            <!-- DASHBOARD -->
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-blue-600 hover:bg-blue-50 p-2 rounded">
                    <span>🏠</span> Dashboard
                </a>
            </li>

            <!-- INSTITUTES (Admin only - Case Insensitive Check) -->
            @if(strtolower(auth()->user()->role) === 'admin')
            <li>
                <a href="{{ route('institutes.index') }}" class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded text-gray-700">
                    <span>🏫</span> Institutes
                </a>
            </li>
            @endif

            <!-- ADMISSIONS MODULE (Sabko dikhega, visually fixed) -->
            <li class="mt-4 pt-2 border-t border-gray-100 font-bold text-gray-800 px-2 uppercase text-xs tracking-wider">
                📄 Admissions Flow
            </li>
            <li class="ml-2">
                <a href="{{ route('admissions.index') }}" class="flex items-center gap-2 hover:text-blue-600 p-2 rounded text-gray-700 transition">
                    🔹 View Admissions
                </a>
            </li>
            <li class="ml-2">
                <a href="{{ route('admissions.create') }}" class="flex items-center gap-2 hover:text-blue-600 p-2 rounded text-gray-700 transition">
                    ➕ Add Admission
                </a>
            </li>

            <!-- USERS MODULE (Admin & Manager Only - Case Insensitive Check) -->
            @if(in_array(strtolower(auth()->user()->role), ['admin', 'manager']))
            <li class="mt-4 pt-2 border-t border-gray-100 font-bold text-gray-800 px-2 uppercase text-xs tracking-wider">
                👥 Users Management
            </li>
            <li class="ml-2">
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 hover:text-blue-600 p-2 rounded text-gray-700 transition">
                    🔹 Manage Users
                </a>
            </li>
            <li class="ml-2">
                <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 hover:text-blue-600 p-2 rounded text-gray-700 transition">
                    ➕ Create User
                </a>
            </li>
            @endif

            <!-- PROFILE -->
            <li class="mt-4 pt-2 border-t border-gray-100">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 hover:bg-gray-100 p-2 rounded text-gray-700">
                    <span>👤</span> Profile
                </a>
            </li>

        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</div>

</body>
</html>