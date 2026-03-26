<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Reset OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Verify Reset OTP</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <p class="text-gray-600 mb-4 text-center">
            Please enter the OTP sent to your email address
        </p>

        <form action="/verify-reset-otp" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="otp" placeholder="Enter 6-digit OTP" class="w-full p-2 border rounded text-center text-lg" required maxlength="6">
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Verify OTP
            </button>
        </form>

        <p class="mt-4 text-center">
            <a href="/forgot-password" class="text-blue-600 hover:underline">Request New OTP</a>
        </p>
    </div>
</body>
</html>