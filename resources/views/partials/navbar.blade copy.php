<nav class="fixed top-4 left-[17rem] w-[calc(100%-18rem)] max-w-[calc(100%-12rem)] bg-white/80 backdrop-blur-md border border-gray-200 rounded-lg z-50 px-6">
    <div class="px-6">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo / Title -->
            <a href="{{ route('dashboard') }}" class="text-xl font-black text-red-600">
                Sistem Disposisi Surat
            </a>

            <!-- Right Menu -->
            <div class="flex items-center space-x-4">
                <!-- Notifikasi -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-gray-700 focus:outline-none">
                        <i class="fas fa-bell text-xl"></i>
                        @if(Auth::user()->notifikasi()->where('dibaca', false)->count() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ Auth::user()->notifikasi()->where('dibaca', false)->count() }}
                            </span>
                        @endif
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl z-50">
                        <div class="p-4 border-b">
                            <h3 class="text-lg font-semibold text-gray-800">Notifikasi</h3>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            @foreach(Auth::user()->notifikasi()->where('dibaca', false)->latest()->limit(5)->get() as $notif)
                                <a href="{{ route('notifikasi.show', $notif->id) }}" class="block p-3 hover:bg-gray-100 border-b">
                                    <p class="font-medium text-gray-800">{{ $notif->judul }}</p>
                                    <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($notif->pesan, 50) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                </a>
                            @endforeach
                            @if(Auth::user()->notifikasi()->where('dibaca', false)->count() == 0)
                                <div class="p-4 text-center text-gray-500">
                                    Tidak ada notifikasi baru
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
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-gray-700 focus:outline-none">
                        <i class="fas fa-user-circle text-xl mr-2"></i>
                        {{ Auth::user()->name }}
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-50">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
