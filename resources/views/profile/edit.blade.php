@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit Profil</h1>
        <p class="text-gray-600">Perbarui informasi akun Anda</p>
    </div>
    
        <a href="{{ route('profile.show') }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i> Kembali
        </a>
    
    </div>
<div class="w-full mx-auto py-8">
    {{-- GRID 2 KOLOM --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- KOLOM KIRI : EDIT PROFIL --}}
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Profil</h2>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nama Lengkap
                    </label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', auth()->user()->name) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                               focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <input type="email" name="email" id="email"
                        value="{{ old('email', auth()->user()->email) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                               focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent
                               rounded-md font-medium text-white hover:bg-indigo-600
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- KOLOM KANAN : UBAH PASSWORD --}}
        <div class="bg-white shadow sm:rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-6">Ubah Kata Sandi</h2>

<form action="{{ route('profile.password.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="space-y-5">

        {{-- PASSWORD SAAT INI --}}
        <div>
            <label class="block text-sm text-gray-600 mb-1">
                Kata Sandi Saat Ini
            </label>
            <div class="relative">
                <input type="password" name="current_password"
                    class="w-full rounded-md border-gray-300 pr-12
                           focus:border-indigo-500 focus:ring-indigo-500">
                <button type="button"
                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400">
                    👁
                </button>
            </div>
        </div>

        {{-- GRID 2 KOLOM --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- PASSWORD BARU --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Kata Sandi Baru
                </label>
                <div class="relative">
                    <input type="password" name="password"
                        class="w-full rounded-md border-gray-300 pr-12
                               focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="button"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400">
                        👁
                    </button>
                </div>
            </div>

            {{-- KONFIRMASI --}}
            <div>
                <label class="block text-sm text-gray-600 mb-1">
                    Konfirmasi Kata Sandi Baru
                </label>
                <div class="relative">
                    <input type="password" name="password_confirmation"
                        class="w-full rounded-md border-gray-300 pr-12
                               focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="button"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400">
                        👁
                    </button>
                </div>
            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end pt-4">
            <button type="submit"
                class="px-6 py-2 bg-green-400 text-white rounded-md
                       hover:bg-green-500 transition">
                Ubah Password
            </button>
        </div>

    </div>
</form>

</div>


    </div>
</div>
@endsection
