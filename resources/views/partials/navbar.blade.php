<nav class="fixed top-4 left-[17rem] w-[calc(100%-18rem)] max-w-[calc(100%-12rem)] bg-white/80 dark:bg-neutral-900/80 backdrop-blur-md border border-gray-200 dark:border-neutral-700 rounded-lg z-50 px-6" id="layout-navbar">
    <div class="px-6">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo / Title -->
            <a href="{{ route('dashboard') }}" class="text-2xl text-neutral-800">
                Sistem Disposisi Surat
            </a>

            <!-- Right Menu -->
            <div class="flex items-center space-x-4">

                <!-- Theme Switcher -->
                <div class="relative" x-data="{ themeOpen: false }">
                    <button @click="themeOpen = !themeOpen" class="flex items-center text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white rounded-full focus:outline-none">
                        <i class="material-symbols-outlined text-xl" x-show="!isDark">light_mode</i>
                        <i class="material-symbols-outlined text-xl" x-show="isDark">dark_mode</i>
                    </button>

                   <div x-show="themeOpen" 
                        @click.away="themeOpen = false" 
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 mt-2 w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-2xl z-50 overflow-hidden p-1">
                        
                        <button @click="isDark = false; localStorage.setItem('dark_mode', false); themeOpen = false" 
                                :class="!isDark ? 'bg-red-50 text-red-600' : 'text-gray-700 dark:text-gray-300'"
                                class="w-full flex items-center text-left px-3 py-2.5 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="material-symbols-outlined mr-3 text-[20px] group-hover:rotate-45 transition-transform">light_mode</i>
                            <span class="text-sm font-medium">Light</span>
                        </button>
                        
                        <button @click="isDark = true; localStorage.setItem('dark_mode', true); themeOpen = false" 
                                :class="isDark ? 'bg-indigo-50 text-indigo-600' : 'text-gray-700 dark:text-gray-300'"
                                class="w-full flex items-center text-left px-3 py-2.5 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="material-symbols-outlined mr-3 text-[20px] group-hover:-rotate-12 transition-transform">dark_mode</i>
                            <span class="text-sm font-medium">Dark</span>
                        </button>
                        
                        <button @click="isDark = window.matchMedia('(prefers-color-scheme: dark)').matches; localStorage.removeItem('dark_mode'); themeOpen = false" 
                                class="w-full flex items-center text-left px-3 py-2.5 text-gray-700 dark:text-gray-300 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i class="material-symbols-outlined mr-3 text-[20px] group-hover:scale-110 transition-transform">devices</i>
                            <span class="text-sm font-medium">System</span>
                        </button>
                    </div>          
                </div>

                <!-- Quick Links -->

                    <div class="relative" x-data="{ quickOpen: false }">
                        <button @click="quickOpen = !quickOpen" class="flex items-center text-gray-700 dark:text-neutral-200 dark:hover:text-[#FF2D20] focus:outline-none">
                            <i class="material-symbols-outlined text-2xl">apps</i>
                        </button>

                        <div x-show="quickOpen" @click.away="quickOpen = false" x-transition
                            class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl z-50">
                            <div class="p-4 border-b">
                                <h3 class="text-lg font-semibold text-gray-800">Pintasan</h3>
                            </div>
                            <div class="p-4 grid grid-cols-2 gap-4">
                                <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2 hover:bg-gray-100 rounded">
                                    <i class="material-symbols-outlined text-3xl mb-1 text-gray-700">dashboard</i>
                                    <span class="text-sm text-gray-700">Dashboard</span>
                                </a>
                                
                                <a href="#" class="flex flex-col items-center p-2 hover:bg-gray-100 rounded">
                                    <i class="material-symbols-outlined text-3xl mb-1 text-gray-700">description</i>
                                    <span class="text-sm text-gray-700">Surat Masuk</span>
                                </a>
                                
                                <a href="#" class="flex flex-col items-center p-2 hover:bg-gray-100 rounded">
                                    <i class="material-symbols-outlined text-3xl mb-1 text-gray-700">send</i>
                                    <span class="text-sm text-gray-700">Surat Keluar</span>
                                </a>
                                
                                <a href="#" class="flex flex-col items-center p-2 hover:bg-gray-100 rounded">
                                    <i class="material-symbols-outlined text-3xl mb-1 text-gray-700">group</i>
                                    <span class="text-sm text-gray-700">Pengguna</span>
                                </a>
                            </div>
                        </div>
                    </div>

                <!-- Notifikasi -->
                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen" class="flex items-center text-gray-700 dark:text-white focus:outline-none">
                        <i class="material-symbols-outlined text-2xl">notifications</i>
                        
                        @if(Auth::user()->notifikasi()->where('dibaca', false)->count() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ Auth::user()->notifikasi()->where('dibaca', false)->count() }}
                            </span>
                        @endif
                    </button>

                    <div x-show="notifOpen" @click.away="notifOpen = false" x-transition
                        class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-xl z-50">
                        
                        <div class="p-4 border-b flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                            @if(Auth::user()->notifikasi()->where('dibaca', false)->count() > 0)
                                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    {{ Auth::user()->notifikasi()->where('dibaca', false)->count() }} Baru
                                </span>
                            @endif
                        </div>

                        <div class="max-h-64 overflow-y-auto">
                            @foreach(Auth::user()->notifikasi()->latest()->limit(5)->get() as $notif)
                                <a href="{{ route('notifikasi.show', $notif->id) }}" class="block p-3 hover:bg-gray-100 border-b {{ $notif->dibaca ? 'bg-gray-50' : '' }}">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-3">
                                            @if($notif->tipe == 'surat_masuk')
                                                <i class="material-symbols-outlined text-blue-500 mt-1">mail</i>
                                            @elseif($notif->tipe == 'disposisi')
                                                <i class="material-symbols-outlined text-green-500 mt-1">forward_to_inbox</i>
                                            @else
                                                <i class="material-symbols-outlined text-gray-500 mt-1">info</i>
                                            @endif
                                        </div>
                                        <div class="flex-grow">
                                            <p class="font-medium text-gray-800">{{ $notif->judul }}</p>
                                            <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($notif->pesan, 50) }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if(!$notif->dibaca)
                                            <div class="flex-shrink-0">
                                                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                            
                            @if(Auth::user()->notifikasi()->count() == 0)
                                <div class="p-4 text-center text-gray-500">
                                    Tidak ada notifikasi
                                </div>
                            @endif
                        </div>

                        <div class="p-2 border-t">
                            <a href="{{ route('notifikasi.index') }}" class="block text-center text-red-600 hover:text-red-800">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="relative" x-data="{ userOpen: false }">
                    <button @click="userOpen = !userOpen" class="flex items-center text-gray-700 dark:text-white focus:outline-none">
                        <img src="{{ Auth::user()->avatar ?? asset('images/user.png') }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full mr-2">
                        {{ Auth::user()->name }}
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>

                    <div x-show="userOpen" @click.away="userOpen = false" x-transition
                         class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-xl z-50">
                        <div class="p-4 border-b">
                            <div class="flex items-center">
                                <img src="{{ Auth::user()->avatar ?? asset('images/user.png') }}" alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-full mr-3">
                                <div>
                                    <p class="font-medium text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->role ?? 'Admin' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="material-symbols-outlined mr-2 text-xl">person</i> Profil Saya
                            </a>
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center text-left px-4 py-2 text-gray-800 hover:bg-red-100 hover:text-red-700">
                                    <i class="material-symbols-outlined mr-2 text-xl">logout</i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>