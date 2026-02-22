<nav
    class="fixed top-4 left-0 right-0 mx-6 z-40
           bg-white/80 dark:bg-brandDark/80 
           backdrop-blur-md
           border border-white/20 dark:border-neutral-800/50
           shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-2xl
           transition-all duration-300"
    :class="sidebarOpen ? 'ml-72' : 'ml-24'"
>
    <div class="px-6">
        <div class="flex justify-between h-16 items-center">
            
            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col">
                    <h2 class="text-sm font-bold text-brandDark dark:text-white leading-tight">
                        Dashboard <span class="text-brandTeal mx-1">/</span> Sistem Disposisi
                    </h2>
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">Graha Perdana Medika</p>
                </div>
            </div>

            <div class="flex items-center space-x-2">

                <button @click="toggle()" 
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100/50 dark:bg-neutral-800 text-slate-600 dark:text-neutral-300 hover:text-brandTeal transition-all">
                    <i class="material-symbols-outlined text-[20px]" x-show="!isDark">light_mode</i>
                    <i class="material-symbols-outlined text-[20px]" x-show="isDark">dark_mode</i>
                </button>

                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen" 
                            class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100/50 dark:bg-neutral-800 text-slate-600 dark:text-neutral-300 hover:text-brandTeal transition-all relative">
                        <i class="material-symbols-outlined text-[20px]">notifications</i>
                        
                        @php $notifCount = Auth::user()->notifikasi()->where('dibaca', false)->count(); @endphp
                        @if($notifCount > 0)
                            <span class="absolute top-2.5 right-2.5 flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brandOrange opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-brandOrange"></span>
                            </span>
                        @endif
                    </button>

                    <div x-show="notifOpen" @click.away="notifOpen = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         class="absolute right-0 mt-3 w-80 bg-white dark:bg-neutral-900 border border-slate-100 dark:border-neutral-800 rounded-2xl shadow-2xl z-50 overflow-hidden shadow-teal-900/10">
                        
                        <div class="p-4 border-b border-slate-50 dark:border-neutral-800 flex justify-between items-center bg-teal-50/30 dark:bg-brandTeal/5">
                            <h3 class="font-bold text-sm text-brandDark dark:text-white">Notifikasi Terbaru</h3>
                            @if($notifCount > 0)
                                <span class="text-[9px] font-black bg-brandTeal text-white px-2 py-0.5 rounded-full uppercase">{{ $notifCount }} Baru</span>
                            @endif
                        </div>

                        <div class="max-h-64 overflow-y-auto">
                            <div class="p-8 text-center">
                                <i class="material-symbols-outlined text-slate-300 text-3xl">notifications_none</i>
                                <p class="text-xs text-slate-500 mt-2 font-medium">Semua sudah terbaca</p>
                            </div>
                        </div>

                        <div class="p-3 bg-slate-50 dark:bg-neutral-800/50 text-center">
                            <a href="#" class="text-[10px] font-black text-brandTeal hover:text-brandOrange uppercase tracking-widest transition-colors">
                                Lihat Semua Aktivitas
                            </a>
                        </div>
                    </div>
                </div>

                <div class="h-6 w-px bg-slate-200 dark:bg-neutral-800 mx-1"></div>

                <div class="relative" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" 
                            class="flex items-center gap-2 p-1 rounded-xl hover:bg-slate-50 dark:hover:bg-neutral-800 transition-all border border-transparent hover:border-slate-100 dark:hover:border-neutral-800">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-brandTeal to-teal-600 flex items-center justify-center text-white font-bold text-xs shadow-sm ring-2 ring-white dark:ring-neutral-900">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <i class="material-symbols-outlined text-slate-400 text-sm">unfold_more</i>
                    </button>

                    <div x-show="userOpen" @click.away="userOpen = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         class="absolute right-0 mt-3 w-56 bg-white dark:bg-neutral-900 border border-slate-100 dark:border-neutral-800 rounded-2xl shadow-2xl z-50 overflow-hidden p-1.5 shadow-teal-900/10">
                        
                        <div class="px-3 py-3 mb-1 bg-teal-50/50 dark:bg-brandTeal/5 rounded-xl">
                            <p class="text-xs font-black text-brandDark dark:text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-brandTeal font-bold truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <a href="{{ route('profile.show') }}" class="flex items-center px-3 py-2 rounded-lg text-xs font-semibold text-slate-600 dark:text-neutral-400 hover:bg-slate-50 dark:hover:bg-neutral-800 transition-colors">
                            <i class="material-symbols-outlined mr-3 text-lg opacity-50">person</i> Pengaturan Profil
                        </a>
                        
                        <div class="h-px bg-slate-100 dark:bg-neutral-800 my-1"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-3 py-2 rounded-lg text-xs font-bold text-brandOrange hover:bg-orange-50 dark:hover:bg-orange-950/20 transition-colors">
                                <i class="material-symbols-outlined mr-3 text-lg">power_settings_new</i> Keluar 
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>