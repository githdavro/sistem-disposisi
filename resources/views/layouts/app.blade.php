<!DOCTYPE html>
<html lang="en" class="{{ session('dark_mode', false) ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Disposisi | GPM')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brandTeal: '#00A99D',
                        brandOrange: '#F37021',
                        brandDark: '#1A1A1A',
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-25..0" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Dark Mode Styling */
        .dark body {
            background-color: #121212;
            color: #e5e7eb;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
    </style>

    @stack('styles')
</head>
<body
    x-data="{
        ...darkMode(),
        sidebarPinned: localStorage.getItem('sidebarPinned') !== 'false',
        sidebarHover: false,
        get sidebarOpen() { return this.sidebarPinned || this.sidebarHover },
        toggleSidebar() {
            this.sidebarPinned = !this.sidebarPinned
            localStorage.setItem('sidebarPinned', this.sidebarPinned)
        }
    }"
    x-init="init()"
    :class="{ 'dark': isDark }"
    class="bg-slate-50/50 transition-colors duration-300"
>

@if(Auth::check())
<div class="flex h-screen overflow-hidden">
    @include('partials.sidebar')

    <div class="flex-1 flex flex-col relative min-w-0 bg-pattern">
        <div class="relative z-30">
            @include('partials.navbar')
        </div>

        <main class="flex-1 p-6 pt-24 overflow-y-auto overflow-x-hidden">
            <div class="max-w-7xl mx-auto">
                @include('partials.flash')
                @yield('content')
            </div>
        </main>

        @include('partials.footer')
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
function darkMode() {
    return {
        isDark: localStorage.getItem('dark_mode') === 'true',
        init() {
            if (this.isDark) document.documentElement.classList.add('dark');
        },
        toggle() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            localStorage.setItem('dark_mode', this.isDark);
        }
    }
}
</script>
@stack('scripts')
</body>
</html>