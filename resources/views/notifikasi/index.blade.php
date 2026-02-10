@extends('layouts.app')

@section('title', 'Daftar Notifikasi')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Notifikasi</h1>
        <p class="text-gray-600">Kelola semua notifikasi Anda</p>
    </div>
    <a href="{{ route('notifikasi.mark-all-read') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-check-double mr-2"></i> Tandai Semua Dibaca
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    No.
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Judul
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Pesan
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Tanggal
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($notifikasi as $index => $notif)
                <tr class="{{ !$notif->dibaca ? 'bg-blue-50' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $index + 1 }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $notif->judul }}
                    </td>
                    <td class="px-6 py-4">
                        {{ Str::limit($notif->pesan, 100) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $notif->dibaca ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $notif->dibaca ? 'Dibaca' : 'Belum Dibaca' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $notif->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('notifikasi.show', $notif->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                        @if(!$notif->dibaca)
                            <a href="{{ route('notifikasi.mark-read', $notif->id) }}" class="text-green-600 hover:text-green-900">
                                <i class="fas fa-check"></i> Tandai Dibaca
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection