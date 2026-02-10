<!DOCTYPE html>
<html lang="en" class="{{ session('dark_mode', false) ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Disposisi Surat')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-25..0" />

    <!-- Custom Style -->
    <style>
        /* Judul / Title */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 900; /* Bold */
        }

        /* Semua paragraf dan konten umum */
        p, span, li, a, div {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500; /* Medium */
        }

        /* Dark Mode Background & Text */
        body.dark {
            background-color: #191919; /* Tailwind gray-800 */
            color: #f9fafb; /* Tailwind gray-50 */
        }
    </style>

    @stack('styles')
</head>
<body
    x-data="{
        ...darkMode(),

        sidebarPinned: localStorage.getItem('sidebarPinned') !== 'false',
        sidebarHover: false,

        get sidebarOpen() {
            return this.sidebarPinned || this.sidebarHover
        },

        toggleSidebar() {
            this.sidebarPinned = !this.sidebarPinned
            localStorage.setItem('sidebarPinned', this.sidebarPinned)
        }
    }"
    x-init="init()"
    :class="{ 'dark': isDark }"
    class="bg-white transition-colors duration-300"
>

@if(Auth::check())
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Konten + Header -->
    <div class="flex-1 flex flex-col relative">
        <!-- Header floating hanya di konten -->
        <div class="relative z-20">
            @include('partials.navbar')
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-6 pt-28 overflow-auto">
            @include('partials.flash')
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function darkMode() {
    return {
        isDark: localStorage.getItem('dark_mode') === 'true' || false,
        init() {
            if (this.isDark) document.body.classList.add('dark');
        },
        toggle() {
            this.isDark = !this.isDark;
            document.body.classList.toggle('dark', this.isDark);
            localStorage.setItem('dark_mode', this.isDark);
        }
    }
}
</script>
@stack('scripts')
</body>
</html>
