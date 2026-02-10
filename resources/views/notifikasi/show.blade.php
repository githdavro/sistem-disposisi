@extends('layouts.app')

@section('title', 'Detail Notifikasi')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail Notifikasi</h1>
        <p class="text-gray-600">Lihat detail informasi notifikasi</p>
    </div>
    <a href="{{ route('notifikasi.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">{{ $notifikasi->judul }}</h2>
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <span class="mr-4">
                <i class="fas fa-calendar-alt mr-1"></i> 
                {{ $notifikasi->created_at->format('d/m/Y H:i') }}
            </span>
            <span>
                <i class="fas fa-clock mr-1"></i> 
                {{ $notifikasi->created_at->diffForHumans() }}
            </span>
        </div>
        
        <div class="mb-4">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                {{ $notifikasi->dibaca ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800' }}">
                {{ $notifikasi->dibaca ? 'Dibaca' : 'Belum Dibaca' }}
            </span>
        </div>
    </div>
    
    <div class="prose max-w-none">
        <p>{{ $notifikasi->pesan }}</p>
    </div>
    
    @if($notifikasi->surat)
        <div class="mt-6 pt-6 border-t">
            <h3 class="text-lg font-semibold mb-4">Informasi Surat Terkait</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Pengirim</p>
                        <p class="font-medium">{{ $notifikasi->surat->pengirim->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tujuan</p>
                        <p class="font-medium">{{ $notifikasi->surat->unitTujuan->nama_unit ?? 'Pengadaan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nominal</p>
                        <p class="font-medium">Rp. {{ number_format($notifikasi->surat->nominal, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="font-medium">{{ $notifikasi->surat->status }}</p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('surat.show', $notifikasi->surat->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-eye mr-2"></i> Lihat Surat
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection