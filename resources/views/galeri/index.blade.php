@extends('layouts.app')

@section('title', 'Galeri Berkas Unit')

@section('content')
<div class="w-full space-y-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Galeri Berkas</h1>
            <p class="text-gray-500 mt-1 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">corporate_fare</span>
                Unit: <span class="font-bold text-[#00A99D]">{{ Auth::user()->unit->nama_unit ?? 'Pusat/Internal' }}</span>
            </p>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="bg-white p-1 rounded-2xl border border-gray-100 flex shadow-sm">
                <button class="p-2 bg-teal-50 text-[#00A99D] rounded-xl"><span class="material-symbols-outlined">grid_view</span></button>
                <button class="p-2 text-gray-400 hover:text-gray-600"><span class="material-symbols-outlined">list</span></button>
            </div>
        </div>
    </div>

    {{-- Stats Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-orange-50 text-[#F37021] rounded-2xl flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">description</span>
            </div>
            <div>
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Berkas</p>
                <h3 class="text-2xl font-black text-gray-900">{{ $berkas->count() }}</h3>
            </div>
        </div>
        {{-- Anda bisa menambah stats lain seperti Berkas Minggu Ini, dll --}}
    </div>

    {{-- File Grid --}}
    @if($berkas->isEmpty())
        <div class="bg-white rounded-[3rem] p-20 border border-dashed border-gray-200 text-center">
            <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">folder_off</span>
            <p class="text-gray-400 font-bold">Belum ada berkas terlampir di unit ini.</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($berkas as $item)
            <div class="group bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-teal-900/5 transition-all duration-300 overflow-hidden relative">
                {{-- Preview Area --}}
                <div class="aspect-square bg-gray-50 flex items-center justify-center relative overflow-hidden">
                    @php
                        $extension = pathinfo($item->file_path, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']);
                    @endphp

                    @if($isImage)
                        <img src="{{ asset('storage/' . $item->file_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <span class="material-symbols-outlined text-5xl text-gray-300">picture_as_pdf</span>
                    @endif

                    {{-- Quick Action Overlay --}}
                    <div class="absolute inset-0 bg-[#00A99D]/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#00A99D] hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">visibility</span>
                        </a>
                        <a href="{{ asset('storage/' . $item->file_path) }}" download class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-[#00A99D] hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">download</span>
                        </a>
                    </div>
                </div>

                {{-- File Info --}}
                <div class="p-5">
                    <h4 class="text-sm font-black text-gray-800 truncate" title="{{ $item->nama_file }}">{{ $item->nama_file }}</h4>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $extension }}</span>
                        <span class="text-[10px] font-bold text-teal-600 bg-teal-50 px-2 py-0.5 rounded-lg">
                            {{ $item->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-50">
                        <p class="text-[10px] text-gray-400 leading-tight">Terkait Surat:</p>
                        <p class="text-[11px] font-bold text-gray-600 truncate italic">#{{ $item->surat->nomor_surat ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-10">
            {{ $berkas->links() }}
        </div>
    @endif
</div>
@endsection