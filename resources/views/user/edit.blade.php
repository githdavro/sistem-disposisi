@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="w-full pb-12">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Pengguna</h1>
            <p class="text-gray-500 mt-1">Kelola data profil dan hak akses akun sistem</p>
        </div>
        <a href="{{ route('user.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-2xl transition-all">
            <span class="material-symbols-outlined mr-2 text-lg">arrow_back</span>
            Kembali ke Daftar
        </a>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden w-full">
        <form action="{{ route('user.update', $user->id) }}" method="POST" class="p-6 md:p-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                {{-- KOLOM KIRI: INFORMASI DASAR --}}
                <div class="space-y-8">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                        <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600">
                            <span class="material-symbols-outlined">account_circle</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Informasi Dasar</h2>
                    </div>

                    <div class="space-y-5">
                        {{-- Nama --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none" value="{{ old('name', $user->name) }}" required>
                            @error('name') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none" value="{{ old('email', $user->email) }}" required>
                            @error('email') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Role --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Peran / Role <span class="text-red-500">*</span></label>
                            <select name="role" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none cursor-pointer" required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role', $userRole) == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Unit --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Unit Kerja</label>
                            <select name="unit_id" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none cursor-pointer">
                                <option value="">Pilih Unit (Opsional)</option>
                                @foreach($unit as $u)
                                    <option value="{{ $u->id }}" {{ old('unit_id', $user->unit_id) == $u->id ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                                @endforeach
                            </select>
                            <p class="text-[11px] text-gray-400 ml-1 italic leading-relaxed">Pilih unit jika pengguna bertugas di departemen spesifik.</p>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: KEAMANAN --}}
                <div class="space-y-8">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                        <div class="p-2.5 bg-amber-50 rounded-xl text-amber-600">
                            <span class="material-symbols-outlined">security</span>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Pengaturan Keamanan</h2>
                    </div>

                    <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
                        <div class="flex gap-3">
                            <span class="material-symbols-outlined text-blue-600">info</span>
                            <p class="text-sm text-blue-700 leading-relaxed font-medium">
                                Kosongkan bidang password di bawah ini jika Anda tidak ingin melakukan perubahan pada kata sandi pengguna saat ini.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        {{-- Password --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Password Baru</label>
                            <input type="password" name="password" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none" placeholder="Masukkan password baru">
                            @error('password') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 ml-1">Ulangi Password Baru</label>
                            <input type="password" name="password_confirmation" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all outline-none" placeholder="Konfirmasi password baru">
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORM FOOTER --}}
            <div class="mt-12 pt-8 border-t border-gray-50 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-400 italic">Terakhir diperbarui: {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <button type="reset" class="flex-1 md:flex-none px-8 py-3.5 text-sm font-bold text-gray-500 hover:bg-gray-50 rounded-2xl transition-all">
                        Reset
                    </button>
                    <button type="submit" class="flex-1 md:flex-none px-12 py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-xl shadow-blue-100 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection