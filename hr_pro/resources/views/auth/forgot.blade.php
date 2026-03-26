<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Forgot Password</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="/reset-password" method="POST" class="space-y-4">
            @csrf
            <input type="email" name="email" placeholder="Enter your email" class="w-full p-2 border rounded" required>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Send Reset OTP
            </button>
        </form>

        <p class="mt-4 text-center">
            <a href="/login" class="text-blue-600 hover:underline">Back to Login</a>
        </p>
    </div>
</body>
</html>