<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HR_PRO')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-blue-700 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">HR_PRO</h1>
            <nav>
                <ul class="flex space-x-4">
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
                        @if(auth()->user()->isAdmin())
                            <li><a href="{{ route('employees.index') }}" class="hover:underline">Employees</a></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="hover:underline">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:underline">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:underline">Register</a></li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 container mx-auto p-4">
        <!-- Flash messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-4 mt-auto">
        <div class="container mx-auto text-center">
            &copy; {{ date('Y') }} HR_PRO. All rights reserved.
        </div>
    </footer>

</body>
</html>