@extends('layouts.app')

@section('title', 'Arsip Lampiran Surat')

@section('content')
{{-- Header Section --}}
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div class="space-y-1">
        <div class="flex items-center gap-2 mb-2">
            <span class="px-3 py-1 bg-brandTeal/10 text-brandTeal text-[10px] font-black uppercase tracking-[0.2em] rounded-full">EDOC - ARCHIVE</span>
        </div>
        <h1 class="text-4xl font-black text-brandDark tracking-tight italic uppercase">Arsip <span class="text-brandTeal">Lampiran</span></h1>
        <p class="text-slate-400 font-medium text-sm">Dokumen arsip digital seluruh lampiran surat terkirim dari semua unit.</p>
    </div>
    
    <div class="flex gap-3">
        <a href="{{ route('surat.index') }}" class="group inline-flex items-center px-6 py-3 bg-white border-2 border-slate-100 rounded-2xl font-black text-xs text-slate-500 uppercase tracking-widest hover:border-brandTeal hover:text-brandTeal shadow-sm transition-all active:scale-95">
            <span class="material-symbols-outlined mr-2 text-lg transition-transform group-hover:-translate-x-1">arrow_back</span>
            Kembali
        </a>
        
        <button onclick="window.print()" class="group inline-flex items-center px-6 py-3 bg-brandTeal text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:shadow-lg hover:shadow-teal-500/30 transition-all active:scale-95">
            <span class="material-symbols-outlined mr-2 text-lg">print</span>
            Cetak Arsip
        </button>
    </div>
</div>

{{-- Filter Section --}}
<div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white p-6 mb-8">
    <form method="GET" action="{{ route('surat.lampiran') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Cari Dokumen</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 text-lg">search</span>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Nama file, pengirim, unit..." 
                       class="w-full pl-12 pr-4 py-3 border-2 border-slate-100 rounded-xl text-sm font-medium focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all">
            </div>
        </div>
        
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Unit Pengirim</label>
            <select name="unit_pengirim" class="w-full px-4 py-3 border-2 border-slate-100 rounded-xl text-sm font-medium focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all">
                <option value="">Semua Unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ request('unit_pengirim') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->nama_unit }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Unit Tujuan</label>
            <select name="unit_tujuan" class="w-full px-4 py-3 border-2 border-slate-100 rounded-xl text-sm font-medium focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all">
                <option value="">Semua Unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ request('unit_tujuan') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->nama_unit }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Periode</label>
            <select name="periode" class="w-full px-4 py-3 border-2 border-slate-100 rounded-xl text-sm font-medium focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all">
                <option value="">Semua Waktu</option>
                <option value="hari" {{ request('periode') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu" {{ request('periode') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan" {{ request('periode') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="tahun" {{ request('periode') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
            </select>
        </div>
        
        <div class="flex gap-2">
            <button type="submit" class="flex-1 px-6 py-3 bg-brandTeal text-white rounded-xl font-black text-xs uppercase tracking-widest hover:shadow-lg hover:shadow-teal-500/30 transition-all">
                Filter
            </button>
            <a href="{{ route('surat.lampiran') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-brandTeal to-teal-600 rounded-[2rem] p-6 text-white shadow-xl shadow-teal-500/20">
        <div class="flex items-center justify-between mb-4">
            <span class="material-symbols-outlined text-3xl text-white/80">description</span>
            <span class="text-3xl font-black">{{ $totalSurat }}</span>
        </div>
        <p class="text-sm font-bold text-white/80 uppercase tracking-wider">Total Dokumen</p>
        <p class="text-xs text-white/60 mt-1">Semua surat terkirim</p>
    </div>
    
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-[2rem] p-6 text-white shadow-xl shadow-orange-500/20">
        <div class="flex items-center justify-between mb-4">
            <span class="material-symbols-outlined text-3xl text-white/80">attach_file</span>
            <span class="text-3xl font-black">{{ $totalLampiran }}</span>
        </div>
        <p class="text-sm font-bold text-white/80 uppercase tracking-wider">Total Lampiran</p>
        <p class="text-xs text-white/60 mt-1">File terlampir</p>
    </div>
    
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-[2rem] p-6 text-white shadow-xl shadow-purple-500/20">
        @php
            $totalSize = $surat->sum(function($s) { 
                return $s->file ? Storage::disk('public')->exists('surat/' . $s->file) ? Storage::disk('public')->size('surat/' . $s->file) : 0 : 0; 
            });
            $sizeInMB = $totalSize / 1048576;
        @endphp
        <div class="flex items-center justify-between mb-4">
            <span class="material-symbols-outlined text-3xl text-white/80">database</span>
            <span class="text-3xl font-black">{{ number_format($sizeInMB, 2) }} MB</span>
        </div>
        <p class="text-sm font-bold text-white/80 uppercase tracking-wider">Total Ukuran</p>
        <p class="text-xs text-white/60 mt-1">Seluruh lampiran</p>
    </div>
    
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-[2rem] p-6 text-white shadow-xl shadow-blue-500/20">
        <div class="flex items-center justify-between mb-4">
            <span class="material-symbols-outlined text-3xl text-white/80">today</span>
            <span class="text-3xl font-black">{{ $suratBulanIni }}</span>
        </div>
        <p class="text-sm font-bold text-white/80 uppercase tracking-wider">Bulan Ini</p>
        <p class="text-xs text-white/60 mt-1">Surat masuk periode</p>
    </div>
</div>

{{-- Daftar Lampiran dengan Grid/List View --}}
<div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white p-8">
    <div class="flex justify-between items-center mb-8">
        <h3 class="font-black text-brandDark uppercase tracking-widest text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-brandTeal">grid_view</span>
            Semua Lampiran File
        </h3>
        <div class="flex gap-2">
            <span class="text-[10px] font-mono text-slate-400 mr-4">Total: {{ $surat->total() }} dokumen</span>
            <button onclick="toggleView('grid')" id="view-grid" class="p-2 bg-brandTeal text-white rounded-lg transition-all">
                <span class="material-symbols-outlined">grid_view</span>
            </button>
            <button onclick="toggleView('list')" id="view-list" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition-all">
                <span class="material-symbols-outlined">view_list</span>
            </button>
        </div>
    </div>

    {{-- Grid View --}}
    <div id="grid-view" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($surat as $item)
        @if($item->file)
        <div class="group bg-white border-2 border-slate-100 rounded-2xl overflow-hidden hover:border-brandTeal hover:shadow-xl hover:shadow-teal-500/10 transition-all duration-300">
            {{-- File Preview --}}
            <div class="h-40 bg-gradient-to-br from-slate-50 to-slate-100 relative overflow-hidden">
                @php
                    $extension = pathinfo($item->file, PATHINFO_EXTENSION);
                    $iconName = match(strtolower($extension)) {
                        'pdf' => 'picture_as_pdf',
                        'doc', 'docx' => 'description',
                        'xls', 'xlsx' => 'table_chart',
                        'jpg', 'jpeg', 'png' => 'image',
                        'zip', 'rar' => 'folder_zip',
                        default => 'insert_drive_file',
                    };
                    $iconColor = match(strtolower($extension)) {
                        'pdf' => 'text-red-500',
                        'doc', 'docx' => 'text-blue-500',
                        'xls', 'xlsx' => 'text-green-500',
                        'jpg', 'jpeg', 'png' => 'text-purple-500',
                        'zip', 'rar' => 'text-orange-500',
                        default => 'text-slate-400',
                    };
                @endphp
                
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="material-symbols-outlined text-7xl {{ $iconColor }} opacity-50 group-hover:scale-110 transition-transform duration-300">
                        {{ $iconName }}
                    </span>
                </div>
                
                {{-- File Type Badge --}}
                <span class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm rounded-lg text-[9px] font-black uppercase tracking-wider shadow-sm">
                    {{ strtoupper($extension) }}
                </span>
                
                {{-- Hover Actions --}}
                <div class="absolute inset-0 bg-brandTeal/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-3">
                    <a href="{{ asset('storage/surat/' . $item->file) }}" target="_blank" 
                       class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-brandTeal hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">visibility</span>
                    </a>
                    <a href="{{ asset('storage/surat/' . $item->file) }}" download
                       class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-brandTeal hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">download</span>
                    </a>
                    <a href="{{ route('surat.show', $item->id) }}" 
                       class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-brandTeal hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">info</span>
                    </a>
                </div>
            </div>
            
            {{-- File Info --}}
            <div class="p-4">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <p class="text-xs font-black text-brandDark truncate max-w-[150px]" title="{{ $item->file }}">
                            {{ Str::limit($item->file, 20) }}
                        </p>
                        <p class="text-[9px] font-bold text-slate-400 mt-0.5">
                            {{ $item->created_at->format('d M Y') }}
                        </p>
                    </div>
                    @php
                        $bytes = Storage::disk('public')->exists('surat/' . $item->file) ? Storage::disk('public')->size('surat/' . $item->file) : 0;
                        $size = $bytes / 1024;
                        $unit = 'KB';
                        if($size > 1024) {
                            $size = $size / 1024;
                            $unit = 'MB';
                        }
                    @endphp
                    <span class="text-[9px] font-black text-slate-400 bg-slate-100 px-2 py-1 rounded-full">
                        {{ number_format($size, 1) }} {{ $unit }}
                    </span>
                </div>
                
                <div class="flex items-center gap-2 mt-2 text-[10px]">
                    <div class="flex items-center gap-1 text-slate-500">
                        <span class="material-symbols-outlined text-xs">person</span>
                        <span class="font-medium truncate max-w-[80px]" title="{{ $item->pengirim->name }}">
                            {{ Str::limit($item->pengirim->name, 12) }}
                        </span>
                    </div>
                    <span class="text-slate-300">•</span>
                    <div class="flex items-center gap-1 text-slate-500">
                        <span class="material-symbols-outlined text-xs">apartment</span>
                        <span class="font-medium truncate max-w-[80px]" title="{{ $item->unitTujuan->nama_unit ?? '-' }}">
                            {{ Str::limit($item->unitTujuan->nama_unit ?? '-', 10) }}
                        </span>
                    </div>
                </div>
                
                @if($item->sifat)
                @php
                    $sifatColor = match($item->sifat) {
                        'Rahasia' => 'bg-red-100 text-red-700',
                        'Penting' => 'bg-orange-100 text-orange-700',
                        'Disegerakan' => 'bg-yellow-100 text-yellow-700',
                        default => 'bg-slate-100 text-slate-700',
                    };
                @endphp
                <div class="mt-2">
                    <span class="inline-block px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-wider {{ $sifatColor }}">
                        {{ $item->sifat }}
                    </span>
                </div>
                @endif
            </div>
        </div>
        @endif
        @empty
        <div class="col-span-full py-16 text-center">
            <div class="flex flex-col items-center justify-center">
                <span class="material-symbols-outlined text-5xl text-slate-300 mb-4">folder_off</span>
                <p class="text-sm font-bold text-slate-400">Belum ada lampiran file</p>
                <p class="text-xs text-slate-300 mt-1">Surat dengan lampiran akan muncul di sini</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- List View (Hidden by default) --}}
    <div id="list-view" class="hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">File</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Pengirim</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Tujuan</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Tanggal</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Ukuran</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($surat as $item)
                    @if($item->file)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $extension = pathinfo($item->file, PATHINFO_EXTENSION);
                                    $listIconColor = match(strtolower($extension)) {
                                        'pdf' => 'text-red-500',
                                        'doc', 'docx' => 'text-blue-500',
                                        'xls', 'xlsx' => 'text-green-500',
                                        'jpg', 'jpeg', 'png' => 'text-purple-500',
                                        default => 'text-slate-400',
                                    };
                                @endphp
                                <span class="material-symbols-outlined {{ $listIconColor }}">description</span>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">{{ Str::limit($item->file, 30) }}</p>
                                    <p class="text-[9px] text-slate-400">{{ $item->nomor_surat ?? 'UNREG-'.str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-slate-700">{{ $item->pengirim->name }}</p>
                            <p class="text-[9px] text-slate-400">{{ $item->pengirim->unit->nama_unit ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-600">{{ $item->unitTujuan->nama_unit ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-slate-600">{{ $item->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $bytes = Storage::disk('public')->exists('surat/' . $item->file) ? Storage::disk('public')->size('surat/' . $item->file) : 0;
                                $size = $bytes / 1024;
                                $unit = 'KB';
                                if($size > 1024) {
                                    $size = $size / 1024;
                                    $unit = 'MB';
                                }
                            @endphp
                            <span class="text-xs font-mono text-slate-500">{{ number_format($size, 1) }} {{ $unit }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ asset('storage/surat/' . $item->file) }}" target="_blank" 
                                   class="p-1.5 bg-slate-100 rounded-lg text-slate-600 hover:bg-brandTeal hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </a>
                                <a href="{{ asset('storage/surat/' . $item->file) }}" download
                                   class="p-1.5 bg-slate-100 rounded-lg text-slate-600 hover:bg-brandTeal hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-sm">download</span>
                                </a>
                                <a href="{{ route('surat.show', $item->id) }}" 
                                   class="p-1.5 bg-slate-100 rounded-lg text-slate-600 hover:bg-brandTeal hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-sm">info</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-4xl text-slate-300 mb-3">folder_off</span>
                                <p class="text-sm font-bold text-slate-400">Belum ada lampiran file</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($surat->hasPages())
    <div class="mt-8 px-4 py-4 border-t border-slate-100">
        {{ $surat->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<script>
function toggleView(view) {
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const gridBtn = document.getElementById('view-grid');
    const listBtn = document.getElementById('view-list');
    
    if (view === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.add('bg-brandTeal', 'text-white');
        gridBtn.classList.remove('bg-slate-100', 'text-slate-600');
        listBtn.classList.remove('bg-brandTeal', 'text-white');
        listBtn.classList.add('bg-slate-100', 'text-slate-600');
        localStorage.setItem('lampiranView', 'grid');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listBtn.classList.add('bg-brandTeal', 'text-white');
        listBtn.classList.remove('bg-slate-100', 'text-slate-600');
        gridBtn.classList.remove('bg-brandTeal', 'text-white');
        gridBtn.classList.add('bg-slate-100', 'text-slate-600');
        localStorage.setItem('lampiranView', 'list');
    }
}

// Load saved preference
document.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('lampiranView') || 'grid';
    toggleView(savedView);
});
</script>
@endsection

@push('styles')
<style>
    @media print {
        aside, .no-print, .sidebar, nav, button, .filter-section, .stats-cards {
            display: none !important;
        }
        body {
            background: white;
        }
        .print-area {
            display: block !important;
        }
    }
</style>
@endpush