<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome | Sistem Disposisi Surat</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            overflow: hidden;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        html {
            scrollbar-width: none;
        }
    </style>
</head>


<body class="bg-gray-50 text-gray-800">

    <!-- WRAPPER FULL SCREEN -->
    <div class="min-h-screen flex flex-col">

        <!-- Navbar -->
        <nav class="w-full fixed top-0 z-50 bg-white/80 backdrop-blur border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
                <h1 class="text-sm sm:text-lg font-bold tracking-wide text-red-600">
                    Sistem disposisi surat PT. GPM
                </h1>

                <div class="space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="text-sm font-semibold text-gray-700 hover:text-red-600 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm font-semibold text-gray-700 hover:text-red-600 transition">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- HERO -->
        <main class="flex-1 flex items-center justify-center relative overflow-hidden pt-24 pb-16">
            <div class="absolute inset-0 bg-gradient-to-br from-red-600/10 via-transparent to-gray-900/10"></div>

            <div class="relative z-10 max-w-4xl text-center px-4 sm:px-6">
                <h2 class="
                    text-3xl 
                    sm:text-4xl 
                    md:text-5xl 
                    font-bold 
                    text-gray-900 
                    leading-tight
                ">
                    Landing page test hehe
                </h2>

                <p class="mt-4 text-gray-600 text-base sm:text-lg">
                    Sistem Disposisi
                </p>

                <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                       class="
                            px-8 py-3 
                            rounded-lg 
                            bg-red-600 
                            text-white 
                            font-semibold 
                            shadow-lg 
                            hover:bg-red-700 
                            transition
                       ">
                        Mulai
                    </a>

                    {{-- @guest
                    <a href="{{ route('register') }}"
                       class="
                            px-8 py-3 
                            rounded-lg 
                            border 
                            border-gray-300 
                            text-gray-700 
                            font-semibold 
                            hover:border-red-600 
                            hover:text-red-600 
                            transition
                       ">
                        Daftar
                    </a>
                    @endguest --}}
                </div>
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="py-4 text-center text-xs sm:text-sm text-gray-500 border-t border-gray-200">
            © {{ date('Y') }} jeneng nde kene. All rights reserved.
        </footer>

    </div>

</body>
</html>
