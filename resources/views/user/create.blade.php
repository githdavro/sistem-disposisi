@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="w-full pb-12">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Tambah Pengguna Baru</h1>
            <p class="text-gray-500 mt-1">Daftarkan akun baru ke dalam sistem disposisi surat PT. GPM</p>
        </div>
        <a href="{{ route('user.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-2xl transition-all">
            <span class="material-symbols-outlined mr-2 text-lg">arrow_back</span>
            Daftar Pengguna
        </a>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden w-full">
        <form action="{{ route('user.store') }}" method="POST" class="p-6 md:p-10">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                {{-- KOLOM KIRI: IDENTITAS PENGGUNA --}}
                <div class="space-y-8">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                        <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600">
                            <span class="material-symbols-outlined">person_add</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Identitas Pengguna</h2>
                    </div>

                    <div class="space-y-5">
                        {{-- Nama --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" placeholder="Contoh: Budi Santoso" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none" value="{{ old('name') }}" required>
                            @error('name') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" placeholder="nama@ptgpm.com" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none" value="{{ old('email') }}" required>
                            @error('email') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Role --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Otoritas / Role <span class="text-red-500">*</span></label>
                            <select name="role" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none cursor-pointer" required>
                                <option value="">Pilih Role Akses</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Unit --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Penempatan Unit</label>
                            <select name="unit_id" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none cursor-pointer">
                                <option value="">Pilih Unit (Opsional)</option>
                                @foreach($unit as $u)
                                    <option value="{{ $u->id }}" {{ old('unit_id') == $u->id ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                                @endforeach
                            </select>
                            <p class="text-[11px] text-gray-400 ml-1 italic leading-relaxed">Kosongkan jika pengguna tidak terikat pada unit tertentu.</p>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: KREDENSIAL --}}
                <div class="space-y-8">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                        <div class="p-2.5 bg-emerald-50 rounded-xl text-emerald-600">
                            <span class="material-symbols-outlined">key</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Kredensial Akun</h2>
                    </div>

                    <div class="p-5 bg-emerald-50 rounded-2xl border border-emerald-100 flex gap-3">
                        <span class="material-symbols-outlined text-emerald-600">verified_user</span>
                        <p class="text-sm text-emerald-700 leading-relaxed">
                            Pastikan password mengandung kombinasi huruf dan angka untuk keamanan tingkat lanjut.
                        </p>
                    </div>

                    <div class="space-y-5">
                        {{-- Password --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" placeholder="Buat password unik" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none" required>
                            @error('password') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER ACTIONS --}}
            <div class="mt-12 pt-8 border-t border-gray-50 flex flex-col md:flex-row items-center justify-end gap-4">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <a href="{{ route('user.index') }}" class="flex-1 md:flex-none px-8 py-3.5 text-center text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-2xl transition-all">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 md:flex-none px-12 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-xl shadow-blue-100 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">person_add_alt</span>
                        Daftarkan Pengguna
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection