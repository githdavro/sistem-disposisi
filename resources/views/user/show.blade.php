@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
<div class="w-full pb-12">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Profil Pengguna</h1>
            <p class="text-gray-500 mt-1">Detail informasi akun dan ringkasan aktivitas sistem</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('user.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm font-bold rounded-2xl hover:bg-gray-50 transition-all shadow-sm">
                <span class="material-symbols-outlined mr-2 text-lg">arrow_back</span>
                Kembali
            </a>
            @if(Auth::user()->hasPermissionTo('user-edit'))
                <a href="{{ route('user.edit', $user->id) }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-indigo-100">
                    <span class="material-symbols-outlined mr-2 text-lg">edit</span>
                    Edit Profil
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KARTU KIRI: IDENTITAS UTAMA --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-8 text-center relative overflow-hidden">
                {{-- Decorative Element --}}
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-blue-500 to-indigo-600 opacity-10"></div>
                
                <div class="relative">
                    <div class="w-28 h-28 mx-auto rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white text-4xl font-black shadow-xl mb-6">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500 font-medium mb-4">{{ $user->email }}</p>
                    
                    @php
                        $role = $user->getRoleNames()->first();
                        $roleClass = match($role) {
                            'Admin' => 'bg-purple-100 text-purple-700',
                            'Direktur' => 'bg-indigo-100 text-indigo-700',
                            'Pengadaan' => 'bg-yellow-100 text-yellow-800',
                            default => 'bg-green-100 text-green-700',
                        };
                    @endphp
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-tighter {{ $roleClass }}">
                        {{ $role }}
                    </span>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-50 space-y-4 text-left">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400 font-medium">Unit Kerja</span>
                        <span class="text-gray-800 font-bold">{{ $user->unit->nama_unit ?? 'Internal PT GPM' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-400 font-medium">Terdaftar Sejak</span>
                        <span class="text-gray-800 font-bold">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KARTU KANAN: STATISTIK & DETAIL --}}
        <div class="lg:col-span-2 space-y-8">
            
{{--  --}}ik Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Surat Terkirim --}}
                <div class="bg-blue-600 rounded-[2rem] p-8 text-white shadow-xl shadow-blue-100 flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-bold uppercase tracking-widest mb-1">Surat Terkirim</p>
                        <h3 class="text-4xl font-black">{{ $user->suratTerkirim->count() }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl">send</span>
                    </div>
                </div>

                {{-- Approval --}}
                <div class="bg-emerald-500 rounded-[2rem] p-8 text-white shadow-xl shadow-emerald-100 flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-bold uppercase tracking-widest mb-1">Disetujui</p>
                        <h3 class="text-4xl font-black">{{ $user->approval->where('status', 'Disetujui')->count() }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl">task_alt</span>
                    </div>
                </div>
            </div>

            {{-- Informasi Tambahan --}}
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800 italic">Informasi Sistem</h3>
                    <span class="px-3 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-lg uppercase tracking-widest">Read-Only</span>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase">Waktu Pembuatan Akun</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->created_at->format('d F Y - H:i') }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase">Terakhir Diperbarui</p>
                        <p class="text-base font-semibold text-gray-800">{{ $user->updated_at->format('d F Y - H:i') }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase">ID Unik Pengguna</p>
                        <p class="text-base font-mono font-bold text-blue-600">GPM-USER-{{ $user->id }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-gray-400 uppercase">Status Akses</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <p class="text-base font-bold text-gray-800">Aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Security Note --}}
            <div class="bg-gray-900 rounded-3xl p-6 text-white flex items-center gap-4">
                <div class="p-3 bg-white/10 rounded-2xl">
                    <span class="material-symbols-outlined text-amber-400">shield_person</span>
                </div>
                <p class="text-sm text-gray-400">
                    Akses pengguna ini dikelola oleh <span class="text-white font-bold">Super Admin</span>. Segala perubahan pada hak akses akan dicatat dalam log audit keamanan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection