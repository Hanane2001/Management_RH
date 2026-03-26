<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded" required>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Login</button>
        </form>
        <p class="mt-2 text-center">
            <a href="/forgot-password" class="text-blue-600 hover:underline">Forgot Password?</a>
        </p>

        <p class="mt-4 text-center">
            Don't have an account? <a href="/register" class="text-blue-600">Register</a>
        </p>
    </div>
</body>
</html>