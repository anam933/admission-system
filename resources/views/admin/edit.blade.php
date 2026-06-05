<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow w-96">

        <h2 class="text-2xl font-bold mb-4">Edit User</h2>

        <form method="POST" action="/admin/update/{{ $user->id }}">
            @csrf

            <input type="text" name="name"
                value="{{ $user->name }}"
                class="w-full p-2 border mb-3 rounded"
                placeholder="Name">

            <input type="email" name="email"
                value="{{ $user->email }}"
                class="w-full p-2 border mb-3 rounded"
                placeholder="Email">

            @if(auth()->id() == $user->id)
                <input type="hidden" name="role" value="{{ $user->role }}">
            @else
            
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="employee">Employee</option>
                </select>
            @endif

            <button class="w-full bg-blue-600 text-white p-2 rounded">
                Update
            </button>

        </form>

    </div>

</div>

</body>
</html>