<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Register</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/register" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="first_name" placeholder="First Name" class="w-full p-2 border rounded" required>
            <input type="text" name="last_name" placeholder="Last Name" class="w-full p-2 border rounded" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-2 border rounded" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full p-2 border rounded" required>
            <input type="text" name="phone" placeholder="Phone" class="w-full p-2 border rounded">
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Register</button>
        </form>

        <p class="mt-4 text-center">
            Already have an account? <a href="/login" class="text-blue-600">Login</a>
        </p>
    </div>
</body>
</html>