<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Enter OTP</h1>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="/otp" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="otp" placeholder="Enter OTP" class="w-full p-2 border rounded" required>
            <button type="submit" class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">Verify OTP</button>
        </form>

        <p class="mt-4 text-center">
            Didn't receive OTP? Check your email.
        </p>
    </div>
</body>
</html>