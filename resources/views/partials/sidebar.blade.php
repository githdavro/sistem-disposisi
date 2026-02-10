<aside class="w-64 bg-white text-gray-800 min-h-screen flex flex-col border-r border-gray-200">
    <!-- Logo -->
    <div class="p-4 flex items-center justify-center border-b border-gray-200">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/gpm_logoonly.webp') }}" alt="Logo PT Graha Perdana Medika" class="w-16 h-16 object-contain">
        </a>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-2 py-4 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-4 py-2 rounded-lg transition-all duration-300 ease-in-out 
                  hover:bg-red-50 hover:text-red-600 {{ request()->routeIs('dashboard') ? 'bg-red-100 text-red-600 shadow-red-200' : '' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>

        <!-- Surat -->
        @if(Auth::user()->hasPermissionTo('surat-list'))
            <a href="{{ route('surat.index') }}"
               class="flex items-center px-4 py-2 rounded-lg transition-all duration-300 ease-in-out 
                      hover:bg-red-50 hover:text-red-600 {{ request()->routeIs('surat.*') ? 'bg-red-100 text-red-600' : '' }}">
                <i class="fas fa-file-alt mr-3"></i>
                Surat
            </a>
        @endif

        <!-- Pengguna -->
        @if(Auth::user()->hasPermissionTo('user-list'))
            <a href="{{ route('user.index') }}"
               class="flex items-center px-4 py-2 rounded-lg transition-all duration-300 ease-in-out 
                      hover:bg-red-50 hover:text-red-600 {{ request()->routeIs('user.*') ? 'bg-red-100 text-red-600' : '' }}">
                <i class="fas fa-users mr-3"></i>
                Pengguna
            </a>
        @endif

        <!-- Unit -->
        @if(Auth::user()->hasPermissionTo('unit-list'))
            <a href="{{ route('unit.index') }}"
               class="flex items-center px-4 py-2 rounded-lg transition-all duration-300 ease-in-out 
                      hover:bg-red-50 hover:text-red-600 {{ request()->routeIs('unit.*') ? 'bg-red-100 text-red-600' : '' }}">
                <i class="fas fa-building mr-3"></i>
                Unit
            </a>
        @endif

        <!-- Notifikasi -->
        <a href="{{ route('notifikasi.index') }}"
           class="flex items-center px-4 py-2 rounded-lg transition-all duration-300 ease-in-out 
                  hover:bg-red-50 hover:text-red-600 {{ request()->routeIs('notifikasi.*') ? 'bg-red-100 text-red-600' : '' }}">
            <i class="fas fa-bell mr-3"></i>
            Notifikasi
            @php
                $notifCount = Auth::user()->notifikasi()->where('dibaca', false)->count();
            @endphp
            @if($notifCount > 0)
                <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse duration-10">
                    {{ $notifCount }}
                </span>
            @endif
        </a>
    </nav>
</aside>
