@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Profil Pengguna</h1>
        <p class="text-gray-600">Lihat dan kelola informasi profil Anda</p>
    </div>
    
        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i> Kembali
        </a>
    
</div>

<div class="bg-white rounded-lg border border-gray-200 p-6">
    <div class="flex items-center mb-6">
        <div class="w-20 h-20 bg-red-500 rounded-full border-4 border-red-100 flex items-center justify-center text-white text-2xl font-bold mr-4">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div>
            <h2 class="text-xl font-semibold">{{ auth()->user()->name }}</h2>
            <p class="text-gray-600">{{ auth()->user()->email }}</p>
            <p class="text-sm text-gray-500">
                Role: <span class="px-2 py-1 rounded-full text-xs font-semibold 
                    {{ auth()->user()->getRoleNames()->first() == 'Admin' ? 'bg-purple-100 text-purple-800' : 
                       (auth()->user()->getRoleNames()->first() == 'Direktur' ? 'bg-indigo-100 text-indigo-800' : 
                       (auth()->user()->getRoleNames()->first() == 'Pengadaan' ? 'bg-yellow-100 text-yellow-800' : 
                       'bg-green-100 text-green-800')) }}">
                    {{ auth()->user()->getRoleNames()->first() }}
                </span>
            </p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold mb-4">Informasi Pribadi</h3>
            <div class="space-y-2">
                <div class="flex">
                    <span class="font-medium w-1/3">Nama:</span>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Email:</span>
                    <span>{{ auth()->user()->email }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Unit:</span>
                    <span>{{ auth()->user()->unit->nama_unit ?? '-' }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Bergabung:</span>
                    <span>{{ auth()->user()->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>
        
        <div>
            <h3 class="text-lg font-semibold mb-4">Statistik</h3>
            <div class="space-y-4">
                <div class="bg-blue-50 p-4 rounded-lg hover:shadow transition">
                    <div class="flex items-center">
                        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-500 text-white mr-4">
                            <span class="material-symbols-outlined text-2xl">
                                send
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Surat Terkirim</p>
                            <p class="text-2xl font-semibold">
                                {{ auth()->user()->suratTerkirim->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Surat Di-approve -->
                <div class="bg-green-50 p-4 rounded-lg hover:shadow transition">
                    <div class="flex items-center">
                        <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-500 text-white mr-4">
                            <span class="material-symbols-outlined text-2xl">
                                check_circle
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Surat Di-approve</p>
                            <p class="text-2xl font-semibold">
                                {{ auth()->user()->approval->where('status', 'Disetujui')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="mt-6 pt-6 border-t">
        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-edit mr-2"></i> Edit Profil
        </a>
    </div>
</div>
@endsection