<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Look For Job</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Alpine.js for dropdown -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="flex flex-col min-h-screen bg-gradient-to-br from-gray-50 to-indigo-100">
    <!-- Navbar -->
    <nav class="bg-gray-900 text-white shadow-sm">
        <div class="container mx-auto flex flex-wrap items-center justify-between px-4 py-3">
            <a href="/" class="font-bold tracking-wide text-lg">Look For Job</a>
            <button data-collapse-toggle="navbarNav" type="button" class="inline-flex items-center p-2 ml-3 text-sm rounded-lg md:hidden focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbarNav" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div class="w-full md:flex md:items-center md:w-auto hidden md:block" id="navbarNav">
                <ul class="flex flex-col mt-4 md:flex-row md:space-x-6 md:mt-0 items-center">
                    <li>
                        <a id="btn-jobs" href="{{ Auth::check() ? '/jobs' : '/login' }}" class="block py-2 px-4 hover:bg-gray-800 rounded transition">Cari Lowongan</a>
                    </li>
                    <li>
                        <a id="btn-cv" href="{{ Auth::check() ? '/cv' : '/login' }}" class="block py-2 px-4 hover:bg-gray-800 rounded transition">Generate CV</a>
                    </li>
                    @auth
                    <li x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 px-2 py-1 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <span class="w-8 h-8 bg-indigo-500 text-white rounded-full flex items-center justify-center font-semibold">
                                {{ Auth::user()->name[0] ?? 'U' }}
                            </span>
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 z-30 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 py-2">
                            <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </li>
                    @else
                    <li>
                        <a href="/login" class="block py-2 px-4 hover:bg-gray-800 rounded transition">Login</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-1">
        <section class="py-16">
            <div class="container mx-auto px-4">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-800">
                        Selamat Datang di <span class="text-indigo-500">Look For Job</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 mb-8">
                        Temukan lowongan kerja impianmu dengan mudah dan buat CV profesional hanya dalam beberapa klik!
                    </p>
                    <a id="btn-jobs" href="{{ Auth::check() ? '/jobs' : '/login' }}" class="inline-block px-7 py-3 mb-2 mr-2 bg-indigo-600 text-white rounded-lg font-medium shadow hover:bg-indigo-700 transition">
                        Cari Lowongan
                    </a>
                    <a id="btn-cv" href="{{ Auth::check() ? '/cv' : '/login' }}" class="inline-block px-7 py-3 mb-2 border border-indigo-600 bg-white text-indigo-600 rounded-lg font-medium shadow hover:bg-indigo-50 transition">
                        Generate CV
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-4">
        <p>&copy; 2025 Look For Job. All rights reserved.</p>
    </footer>

    <!-- Navbar mobile toggle (optional, you can enhance with Alpine.js if needed) -->
    <script>
        document.querySelectorAll('[data-collapse-toggle]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var target = document.getElementById(btn.getAttribute('data-collapse-toggle'));
                target.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>