@extends('layouts.app')

@section('title', 'Dashboard Pengadaan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Pengadaan</h1>
    <p class="text-gray-600">Selamat datang di dashboard Pengadaan</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Surat Masuk</h2>
        <div class="text-3xl font-bold text-blue-600 mb-2">{{ $suratMasuk->count() }}</div>
        <p class="text-gray-600">Surat menunggu proses</p>
        <div class="mt-4">
            <a href="{{ route('surat.index') }}?status=Menunggu" class="text-blue-600 hover:text-blue-800">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Menunggu Approval Direktur</h2>
        <div class="text-3xl font-bold text-yellow-600 mb-2">{{ $suratMenungguApproval->count() }}</div>
        <p class="text-gray-600">Surat yang sedang diproses Direktur</p>
        <div class="mt-4">
            <a href="{{ route('surat.index') }}?status=Diproses" class="text-blue-600 hover:text-blue-800">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Surat Selesai</h2>
        <div class="text-3xl font-bold text-green-600 mb-2">{{ $suratSelesai->count() }}</div>
        <p class="text-gray-600">Surat yang telah selesai diproses</p>
        <div class="mt-4">
            <a href="{{ route('surat.index') }}?status=Selesai" class="text-blue-600 hover:text-blue-800">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Surat yang Perlu Diproses</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No.
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pengirim
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tujuan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nominal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($suratMasuk->take(5) as $index => $surat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $surat->pengirim->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $surat->unitTujuan->nama_unit ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            Rp. {{ number_format($surat->nominal, 2, ',', '.') }}
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
                            <a href="{{ route('surat.show', $surat->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            @if($surat->status == 'Menunggu')
                                <a href="{{ route('surat.proses', $surat->id) }}" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-check"></i> Proses
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-right">
        <a href="{{ route('surat.index') }}" class="text-blue-600 hover:text-blue-800">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>
@endsection