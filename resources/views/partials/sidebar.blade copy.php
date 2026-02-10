<aside class="w-64 bg-panel text-gray-800 min-h-screen flex flex-col rounded-2.5xl shadow-panel overflow-hidden">
    <!-- Logo -->
    <div class="p-4 flex items-center justify-center border-b border-gray-200">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('images/gpm_logoonly.webp') }}" alt="Logo PT Graha Perdana Medika" class="w-16 h-16 object-contain">
        </a>
    </div>

    <!-- Menu -->
    <nav class="flex-1 px-3 py-4 space-y-2 relative">
        <!-- Highlight Active -->
        <div id="active-highlight" class="absolute bg-panel-highlight rounded-xl transition-all duration-500" style="width:0; height:0; top:0; left:0; opacity:0;"></div>

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="menu-item flex items-center px-4 py-3 rounded-xl transition-all duration-300 ease-in-out {{ request()->routeIs('dashboard') ? 'text-red-600 font-medium' : 'text-gray-700 hover:text-red-600' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>

        <!-- Surat -->
        @if(Auth::user()->hasPermissionTo('surat-list'))
            <a href="{{ route('surat.index') }}"
               class="menu-item flex items-center px-4 py-3 rounded-xl transition-all duration-300 ease-in-out {{ request()->routeIs('surat.*') ? 'text-red-600 font-medium' : 'text-gray-700 hover:text-red-600' }}">
                <i class="fas fa-file-alt mr-3"></i>
                Surat
            </a>
        @endif

        <!-- Pengguna -->
        @if(Auth::user()->hasPermissionTo('user-list'))
            <a href="{{ route('user.index') }}"
               class="menu-item flex items-center px-4 py-3 rounded-xl transition-all duration-300 ease-in-out {{ request()->routeIs('user.*') ? 'text-red-600 font-medium' : 'text-gray-700 hover:text-red-600' }}">
                <i class="fas fa-users mr-3"></i>
                Pengguna
            </a>
        @endif

        <!-- Unit -->
        @if(Auth::user()->hasPermissionTo('unit-list'))
            <a href="{{ route('unit.index') }}"
               class="menu-item flex items-center px-4 py-3 rounded-xl transition-all duration-300 ease-in-out {{ request()->routeIs('unit.*') ? 'text-red-600 font-medium' : 'text-gray-700 hover:text-red-600' }}">
                <i class="fas fa-building mr-3"></i>
                Unit
            </a>
        @endif

        <!-- Notifikasi -->
        <a href="{{ route('notifikasi.index') }}"
           class="menu-item flex items-center px-4 py-3 rounded-xl transition-all duration-300 ease-in-out {{ request()->routeIs('notifikasi.*') ? 'text-red-600 font-medium' : 'text-gray-700 hover:text-red-600' }}">
            <i class="fas fa-bell mr-3"></i>
            Notifikasi
            @php
                $notifCount = Auth::user()->notifikasi()->where('dibaca', false)->count();
            @endphp
            @if($notifCount > 0)
                <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                    {{ $notifCount }}
                </span>
            @endif
        </a>
    </nav>
</aside>

<!-- Optional: Script Highlight Active (ala theme contohmu) -->
<script>
    const menuItems = document.querySelectorAll('.menu-item');
    const highlight = document.getElementById('active-highlight');

    function updateHighlight() {
        const activeItem = Array.from(menuItems).find(item => item.classList.contains('text-red-600'));
        if (activeItem) {
            const rect = activeItem.getBoundingClientRect();
            const parentRect = activeItem.parentElement.getBoundingClientRect();
            highlight.style.width = rect.width + 'px';
            highlight.style.height = rect.height + 'px';
            highlight.style.top = (rect.top - parentRect.top) + 'px';
            highlight.style.left = (rect.left - parentRect.left) + 'px';
            highlight.style.opacity = 1;
        } else {
            highlight.style.opacity = 0;
        }
    }

    window.addEventListener('load', updateHighlight);
    window.addEventListener('resize', updateHighlight);
</script>
