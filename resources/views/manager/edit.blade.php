<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow w-96">

        <h2 class="text-2xl font-bold mb-4">Edit Employee</h2>

        <form method="POST" action="/manager/update/{{ $employee->id }}">
            @csrf

            <input type="text"
                name="name"
                value="{{ $employee->name }}"
                class="w-full p-2 border rounded mb-3">

            <input type="email"
                name="email"
                value="{{ $employee->email }}"
                class="w-full p-2 border rounded mb-3">

            <button class="w-full bg-blue-600 text-white p-2 rounded">
                Update
            </button>

        </form>

    </div>

</div>

</body>
</html>