<aside
    @mouseenter="sidebarHover = true"
    @mouseleave="sidebarHover = false"
    :class="sidebarOpen ? 'w-64' : 'w-20'"
    class="bg-white text-slate-700 min-h-screen flex flex-col border-r border-slate-200 transition-all duration-300 ease-in-out shadow-sm"
>
    <div class="h-20 flex items-center px-5 border-b border-slate-100 relative">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 no-underline">
            <div class="bg-teal-50 p-1.5 rounded-xl shrink-0">
               <x-logo-icon class="w-8 h-8 origin-left"/>
            </div>
            
            <span x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                class="font-extrabold text-lg tracking-tight text-slate-800 whitespace-nowrap uppercase">
                GPM <span class="text-[#F37021]">.</span>
            </span>
        </a>

        <button
            x-show="sidebarOpen"
            x-transition.opacity
            @click="toggleSidebar"
            class="absolute -right-3 top-7 bg-white border border-slate-200 w-7 h-7 flex items-center justify-center rounded-full hover:bg-teal-50 hover:border-teal-200 transition-all shadow-sm z-10 group"
        >
            <span class="material-symbols-outlined text-sm text-slate-400 group-hover:text-[#00A99D]"
                  x-text="sidebarPinned ? 'keep' : 'chevron_left'">
            </span>
        </button>
    </div>

    <div class="px-4 mt-6 mb-4">
        @if(Auth::user()->hasPermissionTo('surat-create'))
        <a href="{{ route('surat.create') }}"
           class="flex items-center justify-center gap-3 h-11 rounded-xl bg-[#F37021] text-white shadow-md shadow-orange-100 hover:bg-orange-600 hover:shadow-lg transition-all duration-200 group active:scale-95 overflow-hidden">
            
            <span class="material-symbols-outlined text-[22px]">add_circle</span>

            <span x-show="sidebarOpen" 
                  x-transition.opacity
                  class="text-sm font-bold whitespace-nowrap tracking-wide">
                Buat Surat Baru
            </span>
        </a>
        @endif
    </div>

    <nav class="flex-1 px-3 space-y-1.5 overflow-y-auto">
        
        <p x-show="sidebarOpen" class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-6 mb-2">
            Main Menu
        </p>

        @if(Auth::user()->hasPermissionTo('surat-list'))
        <a href="{{ route('surat.index') }}"
           class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('surat.*') ? 'bg-teal-50 text-[#00A99D] font-bold' : 'hover:bg-slate-50 text-slate-500 hover:text-slate-900' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('surat.*') ? 'text-[#00A99D]' : 'text-slate-400 group-hover:text-slate-600' }}">description</span>
            <span x-show="sidebarOpen" class="ml-3 text-[14px]">Daftar Surat</span>
        </a>
        @endif

        @if(Auth::user()->hasPermissionTo('user-list'))
        <a href="{{ route('user.index') }}"
           class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('user.*') ? 'bg-teal-50 text-[#00A99D] font-bold' : 'hover:bg-slate-50 text-slate-500 hover:text-slate-900' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('user.*') ? 'text-[#00A99D]' : 'text-slate-400 group-hover:text-slate-600' }}">group</span>
            <span x-show="sidebarOpen" class="ml-3 text-[14px]">Manajemen User</span>
        </a>
        @endif

        @if(Auth::user()->hasPermissionTo('unit-list'))
        <a href="{{ route('unit.index') }}"
           class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('unit.*') ? 'bg-teal-50 text-[#00A99D] font-bold' : 'hover:bg-slate-50 text-slate-500 hover:text-slate-900' }}">
            <span class="material-symbols-outlined {{ request()->routeIs('unit.*') ? 'text-[#00A99D]' : 'text-slate-400 group-hover:text-slate-600' }}">corporate_fare</span>
            <span x-show="sidebarOpen" class="ml-3 text-[14px]">Unit Kerja</span>
        </a>
        @endif

        <hr class="mx-3 border-slate-100 my-4">

        <a href="{{ route('notifikasi.index') }}"
           class="flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 group
                  {{ request()->routeIs('notifikasi.*') ? 'bg-teal-50 text-[#00A99D] font-bold' : 'hover:bg-slate-50 text-slate-500 hover:text-slate-900' }}">
            <div class="relative">
                <span class="material-symbols-outlined {{ request()->routeIs('notifikasi.*') ? 'text-[#00A99D]' : 'text-slate-400 group-hover:text-slate-600' }}">notifications</span>
                
                @php $notifCount = Auth::user()->notifikasi()->where('dibaca', false)->count(); @endphp
                @if($notifCount > 0)
                    <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#F37021] border border-white"></span>
                    </span>
                @endif
            </div>
            
            <span x-show="sidebarOpen" class="ml-3 text-[14px] flex-1">Notifikasi</span>

            @if($notifCount > 0)
            <span x-show="sidebarOpen" class="ml-auto bg-[#F37021] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-lg shadow-sm">
                {{ $notifCount }}
            </span>
            @endif
        </a>
    </nav>

    <div x-show="sidebarOpen" class="p-4 bg-slate-50/80 m-3 rounded-2xl border border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-teal-600 flex items-center justify-center text-white font-bold text-xs uppercase shadow-sm shadow-teal-100">
                {{ substr(Auth::user()->name, 0, 2) }}
            </div>
            <div class="flex flex-col overflow-hidden">
                <span class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name }}</span>
                <span class="text-[10px] text-teal-600 font-semibold truncate">{{ Auth::user()->roles->first()->name ?? 'User' }}</span>
            </div>
        </div>
    </div>
</aside>