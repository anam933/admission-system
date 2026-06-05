<div class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="bg-white p-8 rounded-xl shadow-lg w-96">

        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

        <form method="POST" action="/login">
            @csrf

            <input type="email" name="email" placeholder="Email"
                class="w-full p-2 border rounded mb-3">

            <input type="password" name="password" placeholder="Password"
                class="w-full p-2 border rounded mb-3">

            <button class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Login
            </button>
        </form>

    </div>

</div>