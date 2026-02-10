@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

        <div class="shadow-md rounded-lg w-full 
            flex items-center justify-center
            shadow-lg px-6 py-9 mb-9 relative"
            style="
                background-image: 
                    url('/images/background.svg'),
                    linear-gradient(to bottom right, rgba(220,38,38,0.2), rgba(251,191,36,0.1));
                background-size: cover;
                background-repeat: no-repeat;
                background-blend-mode: overlay;
            ">

            <div class="flex flex-col items-center text-center space-y-2 relative z-10">

                <h2 class="text-3xl font-black text-gray-900 tracking-wide">
                    Selamat Datang, {{ Auth::user()->name }}! 
                </h2>

                <p class="text-base text-gray-900">
                Dashboard Admin Sistem disposisi surat PT. GPM
                </p>

            </div>
        </div>
{{-- <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600">Selamat datang di dashboard admin sistem disposisi surat</p>
</div> --}}



<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-200 text-[#FF2D20] mr-4">
                <i class="fas fa-file-alt text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Surat</p>
                <p class="text-2xl font-semibold">{{ $totalSurat }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-500 text-white mr-4">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Disetujui</p>
                <p class="text-2xl font-semibold">{{ $suratDisetujui }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-500 text-white mr-4">
                <i class="fas fa-times-circle text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Ditolak</p>
                <p class="text-2xl font-semibold">{{ $suratDitolak }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-500 text-white mr-4">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Menunggu</p>
                <p class="text-2xl font-semibold">{{ $suratMenunggu }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h2 class="text-xl font-semibold mb-4">Statistik Surat per Unit</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Unit
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Jumlah Surat
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($statistikPerUnit as $unit)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $unit->nama_unit }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $unit->surat_tujuan_count }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection