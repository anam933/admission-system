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

        <span class="font-semibold">
            {{ auth()->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Logout
            </button>
        </form>

    </div>

</nav>

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 h-screen bg-white shadow p-4">

        <ul class="space-y-4 font-semibold">

            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users.index') }}">
                    Users List
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users.create') }}">
                    Create User
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