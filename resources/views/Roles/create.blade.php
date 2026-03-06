@extends('layouts.app')

@section('title', 'Tambah Role Baru')

@section('content')
<div class="w-full max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('roles.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 text-gray-400 hover:text-indigo-600 transition-all">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Buat Role Baru</h1>
            <p class="text-gray-500 mt-1">Tentukan nama role dan pilih izin (permissions) yang sesuai.</p>
        </div>
    </div>

    {{-- Form Card --}}
    <form action="{{ route('roles.store') }}" method="POST" class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        @csrf
        <div class="p-8 md:p-12 space-y-10">
            {{-- Role Name Input --}}
            <div class="space-y-3">
                <label for="name" class="text-sm font-black text-gray-400 uppercase tracking-widest ml-1">Nama Role</label>
                <input type="text" name="name" id="name" placeholder="Contoh: Manager Operasional" 
                    class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all font-bold text-gray-900 placeholder:text-gray-300" required>
                @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            {{-- Permissions Grid --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <label class="text-sm font-black text-gray-400 uppercase tracking-widest ml-1">Hak Akses (Permissions)</label>
                    <span class="text-[10px] bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full font-black uppercase tracking-tighter">Pilih Minimal Satu</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($permission as $value)
                        <label class="group relative flex items-center p-4 bg-gray-50 hover:bg-indigo-50 border-2 border-transparent hover:border-indigo-100 rounded-2xl transition-all cursor-pointer overflow-hidden">
                            <div class="flex items-center gap-4 z-10">
                                <input type="checkbox" name="permission[]" value="{{ $value->id }}" 
                                    class="w-5 h-5 rounded-lg border-gray-300 text-indigo-600 focus:ring-indigo-500/30 transition-all cursor-pointer">
                                <span class="text-sm font-bold text-gray-600 group-hover:text-indigo-700 transition-colors">{{ $value->name }}</span>
                            </div>
                            {{-- Dekorasi Hover --}}
                            <div class="absolute -right-2 -bottom-2 opacity-0 group-hover:opacity-10 transition-opacity">
                                <span class="material-symbols-outlined text-6xl text-indigo-600">verified_user</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('permission') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3">
            <button type="reset" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">Reset</button>
            <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black rounded-2xl shadow-lg shadow-indigo-100 transition-all transform active:scale-95">
                Simpan Role
            </button>
        </div>
    </form>
</div>
@endsection