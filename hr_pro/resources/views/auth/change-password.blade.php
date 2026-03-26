<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Change Password</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/change-password" method="POST" class="space-y-4">
            @csrf
            <input type="password" name="password" placeholder="New Password" class="w-full p-2 border rounded" required minlength="6">
            <input type="password" name="password_confirmation" placeholder="Confirm New Password" class="w-full p-2 border rounded" required>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Change Password
            </button>
        </form>

        <p class="mt-4 text-center">
            <a href="/login" class="text-blue-600 hover:underline">Back to Login</a>
        </p>
    </div>
</body>
</html>