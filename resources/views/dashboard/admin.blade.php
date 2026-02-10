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

                <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-wide">
                    Selamat Datang, {{ Auth::user()->name }}! 
                </h2>

                <p class="text-base text-gray-900 dark:text-neutral-100/90">
                Dashboard Admin Sistem disposisi surat PT. GPM
                </p>

            </div>
        </div>
{{-- <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600">Selamat datang di dashboard admin sistem disposisi surat</p>
</div> --}}



<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg border border-gray-200 p-6 hover:border-blue-500 transition duration-300">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-500/10 text-blue-500 focus:outline-none focus-visible:ring-blue mr-4 flex items-center justify-center">
                 <span class="material-symbols-outlined">forward_to_inbox</span>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Total Surat</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalSurat }}</p>
            </div>
        </div>
    </div>


    <div class="bg-white rounded-lg border border-gray-200 p-6 hover:border-green-500 transition duration-300">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-500/10 text-green-500 focus:outline-none focus-visible:ring-green mr-4 flex items-center justify-center">
                 <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Disetujui</p>
                <p class="text-3xl font-bold text-gray-800">{{ $suratDisetujui }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6 hover:border-red-500 transition duration-300">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-[#FF2D20]/10 text-[#FF2D20] focus:outline-none focus-visible:ring-[#FF2D20] mr-4 flex items-center justify-center">
                <span class="material-symbols-outlined">cancel</span>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Surat Ditolak</p>
                <p class="text-3xl font-bold text-gray-800">{{ $suratDitolak }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6 hover:border-amber-500 transition duration-300">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-amber-500/10 text-amber-500 focus:outline-none focus-visible:ring-amber mr-4 flex items-center justify-center">
                 <span class="material-symbols-outlined">hourglass</span>
            </div>
            <div>
                <p class="text-gray-400 text-sm">Menunggu</p>
                <p class="text-3xl font-bold text-gray-800">{{ $suratMenunggu }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h2 class="text-xl font-semibold mb-4">Statistik Surat per Unit</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                        Unit
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-black text-gray-500 uppercase tracking-wider">
                        Jumlah Surat
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($statistikPerUnit as $unit)
                    <tr class="hover:bg-red-50">
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