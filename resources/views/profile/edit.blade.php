@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="w-full mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Pengaturan Akun</h1>
            <p class="text-gray-500 mt-1">Kelola informasi identitas dan keamanan kata sandi Anda.</p>
        </div>
        
        <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
            <span class="material-symbols-outlined text-sm mr-2">arrow_back</span>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

        {{-- KOLOM KIRI: INFORMASI PROFIL --}}
        <div class="flex flex-col bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md">
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50 flex items-center">
                <span class="material-symbols-outlined text-indigo-600 mr-3">badge</span>
                <h2 class="text-lg font-bold text-gray-800">Informasi Profil</h2>
            </div>

            <div class="p-8 flex-grow flex flex-col">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6 flex-grow flex flex-col">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5 flex-grow">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 ml-1">Nama Lengkap</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', auth()->user()->name) }}" required
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50/30 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 sm:text-sm placeholder-gray-400"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="text-xs text-red-500 mt-2 flex items-center ml-1">
                                    <span class="material-symbols-outlined text-xs mr-1">error</span> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2 ml-1">Alamat Email</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', auth()->user()->email) }}" required
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50/30 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all duration-200 sm:text-sm placeholder-gray-400"
                                placeholder="nama@perusahaan.com">
                            @error('email')
                                <p class="text-xs text-red-500 mt-2 flex items-center ml-1">
                                    <span class="material-symbols-outlined text-xs mr-1">error</span> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center px-5 py-3.5 bg-indigo-600 border border-transparent rounded-xl font-bold text-white hover:bg-indigo-700 shadow-lg shadow-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all active:scale-[0.98]">
                            <span class="material-symbols-outlined text-sm mr-2">save</span>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- KOLOM KANAN: UBAH PASSWORD --}}
        <div class="flex flex-col bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md">
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50 flex items-center">
                <span class="material-symbols-outlined text-emerald-600 mr-3">lock_reset</span>
                <h2 class="text-lg font-bold text-gray-800">Keamanan Password</h2>
            </div>

            <div class="p-8 flex-grow flex flex-col">
                <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-6 flex-grow flex flex-col">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5 flex-grow">
                        {{-- PASSWORD SAAT INI --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Kata Sandi Saat Ini</label>
                            <div class="relative group">
                                <input type="password" name="current_password" required
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50/30 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all duration-200 pr-12"
                                    placeholder="••••••••">
                                <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-400 hover:text-emerald-500 transition-colors">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- PASSWORD BARU --}}
                            <div class="md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Password Baru</label>
                                <div class="relative group">
                                    <input type="password" name="password" required
                                        class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50/30 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all duration-200 pr-12"
                                        placeholder="Min. 8 char">
                                    <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-400 hover:text-emerald-500 transition-colors">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </button>
                                </div>
                            </div>

                            {{-- KONFIRMASI --}}
                            <div class="md:col-span-1">
                                <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">Konfirmasi</label>
                                <div class="relative group">
                                    <input type="password" name="password_confirmation" required
                                        class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50/30 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all duration-200 pr-12"
                                        placeholder="Ulangi password">
                                    <button type="button" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-400 hover:text-emerald-500 transition-colors">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="pt-6">
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center px-6 py-3.5 bg-emerald-500 border border-transparent rounded-xl font-bold text-white hover:bg-emerald-600 shadow-lg shadow-emerald-100 transition-all active:scale-[0.98]">
                            <span class="material-symbols-outlined text-sm mr-2">key</span>
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    document.querySelectorAll('button[type="button"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('.material-symbols-outlined');
            if (input.type === "password") {
                input.type = "text";
                icon.textContent = "visibility_off";
            } else {
                input.type = "password";
                icon.textContent = "visibility";
            }
        });
    });
</script>
@endsection