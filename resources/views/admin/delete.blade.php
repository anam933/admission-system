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

            <select name="role" class="w-full p-2 border mb-3 rounded">
                <option value="employee" {{ $user->role=='employee'?'selected':'' }}>Employee</option>
                <option value="manager" {{ $user->role=='manager'?'selected':'' }}>Manager</option>
                <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
            </select>

            <button class="w-full bg-blue-600 text-white p-2 rounded">
                Update
            </button>

        </form>

    </div>

</div>

</body>
</html>