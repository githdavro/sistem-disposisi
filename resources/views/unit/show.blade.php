@extends('layouts.app')

@section('title', 'Detail Unit')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail Unit</h1>
        <p class="text-gray-600">Lihat detail informasi unit</p>
    </div>
    <a href="{{ route('unit.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold mb-4">Informasi Unit</h3>
            <div class="space-y-2">
                <div class="flex">
                    <span class="font-medium w-1/3">Nama Unit:</span>
                    <span>{{ $unit->nama_unit }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Jumlah User:</span>
                    <span>{{ $unit->user->count() }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Tanggal Dibuat:</span>
                    <span>{{ $unit->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
        
        <div>
            <h3 class="text-lg font-semibold mb-4">Statistik</h3>
            <div class="space-y-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 text-white mr-4">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Surat Masuk</p>
                            <p class="text-2xl font-semibold">{{ $unit->suratTujuan->count() }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Total User</p>
                            <p class="text-2xl font-semibold">{{ $unit->user->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-6 pt-6 border-t">
        @if(Auth::user()->hasPermissionTo('unit-edit'))
            <a href="{{ route('unit.edit', $unit->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
        @endif
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Daftar User</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No.
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nama
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($unit->user as $index => $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->getRoleNames()->first() == 'Admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->getRoleNames()->first() == 'Direktur' ? 'bg-indigo-100 text-indigo-800' : 
                                   ($user->getRoleNames()->first() == 'Pengadaan' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-green-100 text-green-800')) }}">
                                {{ $user->getRoleNames()->first() }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection