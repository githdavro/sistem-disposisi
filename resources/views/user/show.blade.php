@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pengguna</h1>
        <p class="text-gray-600">Lihat detail informasi pengguna</p>
    </div>
    <a href="{{ route('user.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold mb-4">Informasi Pengguna</h3>
            <div class="space-y-2">
                <div class="flex">
                    <span class="font-medium w-1/3">Nama:</span>
                    <span>{{ $user->name }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Email:</span>
                    <span>{{ $user->email }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Unit:</span>
                    <span>{{ $user->unit->nama_unit ?? '-' }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Role:</span>
                    <span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->getRoleNames()->first() == 'Admin' ? 'bg-purple-100 text-purple-800' : 
                               ($user->getRoleNames()->first() == 'Direktur' ? 'bg-indigo-100 text-indigo-800' : 
                               ($user->getRoleNames()->first() == 'Pengadaan' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-green-100 text-green-800')) }}">
                            {{ $user->getRoleNames()->first() }}
                        </span>
                    </span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Tanggal Dibuat:</span>
                    <span>{{ $user->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
        
        <div>
            <h3 class="text-lg font-semibold mb-4">Statistik</h3>
            <div class="space-y-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 text-white mr-4">
                            <i class="fas fa-paper-plane text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Surat Terkirim</p>
                            <p class="text-2xl font-semibold">{{ $user->suratTerkirim->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Surat Di-approve</p>
                            <p class="text-2xl font-semibold">{{ $user->approval->where('status', 'Disetujui')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-6 pt-6 border-t">
        @if(Auth::user()->hasPermissionTo('user-edit'))
            <a href="{{ route('user.edit', $user->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
        @endif
    </div>
</div>
@endsection