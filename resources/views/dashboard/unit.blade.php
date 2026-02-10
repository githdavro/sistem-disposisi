@extends('layouts.app')

@section('title', 'Dashboard Unit')

@section('content')

        <div class="shadow-md rounded-lg w-full 
            flex items-center justify-center
            shadow-lg px-6 py-6 mb-6 relative"
            style="
                background-image: 
                    url('/images/background.svg'),
                    linear-gradient(to bottom right, rgba(220,38,38,0.2), rgba(251,191,36,0.1));
                background-size: cover;
                background-repeat: no-repeat;
                background-blend-mode: overlay;
            ">

            <canvas class="confetti-canvas absolute inset-0"></canvas>

            <div class="flex flex-col items-center text-center space-y-2 relative z-10">

                <svg class="h-10 w-10 text-gray-900 flex-shrink-0" fill="currentColor" viewBox="0 0 319 491" xmlns="http://www.w3.org/2000/svg">
                    <g id="Background">
                        <!-- SVG Paths -->
                    </g>
                </svg>

                <h2 class="text-2xl font-bold text-gray-900 tracking-wide">
                    Selamat Datang, {{ Auth::user()->name }}! 
                </h2>

                <h2 class="text-base font-bold text-gray-900">
                Dashboard Unit sistem disposisi surat PT. GPM
                </h2>

            </div>
        </div>


{{-- <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Unit</h1>
    <p class="text-gray-600">Selamat datang di dashboard unit</p>
</div> --}}

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Surat Terkirim --}}
    <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Surat Terkirim</h2>

    @if($suratTerkirim->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tujuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sifat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($suratTerkirim->take(5) as $index => $surat)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $surat->unitTujuan->nama_unit ?? 'Pengadaan' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $surat->sifat == 'Rahasia' ? 'bg-red-100 text-red-800' : 
                                       ($surat->sifat == 'Penting' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-blue-100 text-blue-800') }}">
                                    {{ $surat->sifat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $surat->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($surat->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 
                                       ($surat->status == 'Disetujui' ? 'bg-green-100 text-green-800' : 
                                       ($surat->status == 'Ditolak' ? 'bg-red-100 text-red-800' : 
                                       'bg-gray-100 text-gray-800'))) }}">
                                    {{ $surat->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('surat.show', $surat->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    @else
        <p class="text-gray-500 text-center py-8">Belum ada surat terkirim</p>
        
    @endif
    <div class="mt-4 text-right">
            <a href="{{ route('surat.index') }}" class="text-red-600 hover:text-red-800">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
</div>

    <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Surat Masuk</h2>

    @if($suratMasuk->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengirim</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sifat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($suratMasuk->take(5) as $index => $surat)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $surat->pengirim->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $surat->sifat == 'Rahasia' ? 'bg-red-100 text-red-800' : 
                                       ($surat->sifat == 'Penting' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-blue-100 text-blue-800') }}">
                                    {{ $surat->sifat }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $surat->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($surat->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 
                                       ($surat->status == 'Disetujui' ? 'bg-green-100 text-green-800' : 
                                       ($surat->status == 'Ditolak' ? 'bg-red-100 text-red-800' : 
                                       'bg-gray-100 text-gray-800'))) }}">
                                    {{ $surat->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('surat.show', $surat->id) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    @else
        <p class="text-gray-500 text-center py-8">Belum ada surat baru</p>
    @endif
    <div class="mt-4 text-right">
            <a href="{{ route('surat.index') }}" class="text-blue-600 hover:text-blue-800">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>
</div>


<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Notifikasi Terbaru</h2>
    <div class="space-y-3">
        @foreach($notifikasi->take(5) as $notif)
            <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0">
                    <i class="fas fa-bell text-blue-500 mt-1"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ $notif->judul }}</p>
                    <p class="text-sm text-gray-500">{{ $notif->pesan }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex-shrink-0 ml-2">
                    <a href="{{ route('notifikasi.show', $notif->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        Lihat
                    </a>
                </div>
            </div>
        @endforeach
        @if($notifikasi->count() == 0)
            <p class="text-gray-500 text-center py-4">Tidak ada notifikasi baru</p>
        @endif
    </div>
    <div class="mt-4 text-right">
        <a href="{{ route('notifikasi.index') }}" class="text-blue-600 hover:text-blue-800">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>
@endsection