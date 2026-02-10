<aside
    @mouseenter="sidebarHover = true"
    @mouseleave="sidebarHover = false"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-white text-gray-800 min-h-screen flex flex-col border-r border-gray-200
           transition-all duration-300 ease-in-out">


    <!-- Logo + Hamburger -->
    <div class="p-4 flex items-center border-b border-gray-200 relative">
    
        <!-- Logo (FIX SIZE, TIDAK CENTER, TIDAK MENGECIL) -->
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/gpm_logoonly.webp') }}"
                alt="Logo"
                class="w-10 h-10 object-contain shrink-0">

            <!-- Text hanya hilang saat collapse -->
            <span x-show="sidebarOpen"
                x-transition
                class="font-bold text-sm whitespace-nowrap">
                GPM
            </span>
        </a>

        <!-- Hamburger (pojok kanan, ga ngedorong logo) -->
        <!-- Hamburger (HANYA MUNCUL SAAT SIDEBAR TERBUKA) -->
        <!-- Toggle Sidebar (Google Material Symbols) -->
        <button
            x-show="sidebarOpen"
            x-transition.opacity
            @click="toggleSidebar"
            :class="sidebarPinned ? 'text-red-600' : 'text-gray-600'"
            class="absolute right-4 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
        >
            <span
                class="material-symbols-outlined"
                x-text="sidebarPinned ? 'radio_button_checked' : 'radio_button_checked'">
            </span>
        </button>

    </div>


    <!-- Menu -->
    <nav class="flex-1 px-2 py-4 space-y-1">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-4 py-2 rounded-lg transition
                  hover:bg-red-50 hover:text-red-600
                  {{ request()->routeIs('dashboard') ? 'bg-red-100 text-red-600' : '' }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span x-show="sidebarOpen" x-transition class="ml-3">Dashboard</span>
        </a>

        <!-- Surat -->
        @if(Auth::user()->hasPermissionTo('surat-list'))
        <a href="{{ route('surat.index') }}"
           class="flex items-center px-4 py-2 rounded-lg transition
                  hover:bg-red-50 hover:text-red-600
                  {{ request()->routeIs('surat.*') ? 'bg-red-100 text-red-600' : '' }}">
            <span class="material-symbols-outlined">description</span>
            <span x-show="sidebarOpen" x-transition class="ml-3">Surat</span>
        </a>
        @endif

        <!-- Pengguna -->
        @if(Auth::user()->hasPermissionTo('user-list'))
        <a href="{{ route('user.index') }}"
           class="flex items-center px-4 py-2 rounded-lg transition
                  hover:bg-red-50 hover:text-red-600
                  {{ request()->routeIs('user.*') ? 'bg-red-100 text-red-600' : '' }}">
            <span class="material-symbols-outlined">group</span>
            <span x-show="sidebarOpen" x-transition class="ml-3">Pengguna</span>
        </a>
        @endif

        <!-- Unit -->
        @if(Auth::user()->hasPermissionTo('unit-list'))
        <a href="{{ route('unit.index') }}"
           class="flex items-center px-4 py-2 rounded-lg transition
                  hover:bg-red-50 hover:text-red-600
                  {{ request()->routeIs('unit.*') ? 'bg-red-100 text-red-600' : '' }}">
            <span class="material-symbols-outlined">apartment</span>
            <span x-show="sidebarOpen" x-transition class="ml-3">Unit</span>
        </a>
        @endif

        <!-- Notifikasi -->
        <a href="{{ route('notifikasi.index') }}"
           class="flex items-center px-4 py-2 rounded-lg transition
                  hover:bg-red-50 hover:text-red-600
                  {{ request()->routeIs('notifikasi.*') ? 'bg-red-100 text-red-600' : '' }}">
            <span class="material-symbols-outlined">notifications</span>
            <span x-show="sidebarOpen" x-transition class="ml-3">Notifikasi</span>

            @php
                $notifCount = Auth::user()->notifikasi()->where('dibaca', false)->count();
            @endphp

            @if($notifCount > 0)
            <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5
                         flex items-center justify-center animate-pulse">
                {{ $notifCount }}
            </span>
            @endif
        </a>

    </nav>
</aside>
