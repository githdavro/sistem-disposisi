@extends('layouts.app')

@section('title', 'Arsip & Daftar Surat | GPM')

@section('content')
<div class="w-full space-y-8 pb-12">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-brandDark dark:text-white tracking-tight flex items-center gap-3">
                <span class="p-2 bg-brandTeal/10 text-brandTeal rounded-xl shrink-0">
                    <i class="material-symbols-outlined text-3xl">inventory</i>
                </span>
                Arsip & Daftar Surat
            </h1>
            <p class="text-slate-500 dark:text-neutral-400 mt-1 font-medium ml-14">Monitoring alur disposisi dan status dokumen internal.</p>
        </div>
        
        @if(Auth::user()->hasPermissionTo('surat-create'))
            <a href="{{ route('surat.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-brandTeal hover:bg-teal-600 text-white text-sm font-black rounded-[1.5rem] shadow-xl shadow-teal-900/10 transition-all transform active:scale-95 group">
                <span class="material-symbols-outlined mr-2 text-xl font-bold group-hover:rotate-90 transition-transform">add_circle</span>
                BUAT SURAT BARU
            </a>
        @endif
    </div>

   {{-- FILTER & SORT CONTAINER --}}
<div x-data="{ expanded: {{ request()->anyFilled(['unit', 'min_nominal', 'max_nominal', 'date_from', 'date_to', 'sifat']) ? 'true' : 'false' }} }" class="w-full">
    
    <form action="{{ route('surat.index') }}" method="GET" class="bg-white dark:bg-neutral-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-neutral-800 p-3 transition-all duration-500">
        
        {{-- Bar Utama (Minimalis) --}}
        <div class="flex flex-col lg:flex-row items-center gap-3">
            
            {{-- Search Utama --}}
            <div class="relative flex-1 w-full group">
                <i class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-brandTeal transition-colors">search</i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor surat atau perihal..." 
                       class="w-full pl-14 pr-6 py-4 bg-slate-50 dark:bg-neutral-800 border-none rounded-[1.5rem] text-xs font-bold focus:ring-2 focus:ring-brandTeal/20 transition-all placeholder:text-slate-400">
            </div>

            {{-- Action Group --}}
            <div class="flex items-center gap-2 w-full lg:w-auto">
                {{-- Quick Status --}}
                <select name="status" onchange="this.form.submit()" class="flex-1 lg:w-44 px-5 py-4 bg-slate-50 dark:bg-neutral-800 border-none rounded-[1.5rem] text-[10px] font-black uppercase tracking-wider focus:ring-2 focus:ring-brandTeal/20 cursor-pointer transition-all">
                    <option value="">Semua Status</option>
                    @foreach(['Menunggu', 'Diproses', 'Disetujui', 'Ditolak', 'Selesai'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>

                {{-- Quick Sort --}}
                <select name="sort" onchange="this.form.submit()" class="hidden md:block px-5 py-4 bg-slate-50 dark:bg-neutral-800 border-none rounded-[1.5rem] text-[10px] font-black uppercase tracking-wider focus:ring-2 focus:ring-brandTeal/20 cursor-pointer transition-all">
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru ↓</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama ↑</option>
                </select>

                {{-- Toggle Advanced --}}
                <button type="button" @click="expanded = !expanded" 
                        :class="expanded ? 'bg-brandDark text-white' : 'bg-slate-100 dark:bg-neutral-800 text-slate-500'"
                        class="w-14 h-14 flex items-center justify-center rounded-[1.5rem] hover:opacity-80 transition-all shrink-0">
                    <i class="material-symbols-outlined transition-transform duration-300" :class="expanded ? 'rotate-180' : ''">tune</i>
                </button>

                {{-- Submit Button --}}
                <button type="submit" class="px-8 h-14 bg-brandTeal text-white text-[11px] font-black uppercase tracking-widest rounded-[1.5rem] shadow-lg shadow-teal-500/20 hover:bg-teal-600 transition-all active:scale-95 shrink-0">
                    Cari
                </button>
            </div>
        </div>

        {{-- Advanced Options (Area Expand) --}}
        <div x-show="expanded" 
             x-collapse
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="px-4 overflow-hidden">
            
            <div class="pt-8 pb-4 grid grid-cols-1 md:grid-cols-3 gap-10 border-t border-slate-50 dark:border-neutral-800 mt-5">
                
                {{-- Col 1: Origin & Property --}}
                <div class="space-y-4">
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.15em] text-slate-400">
                        <span class="w-1 h-1 rounded-full bg-brandTeal"></span> Identitas & Sifat
                    </label>
                    <div class="space-y-3">
                        <input type="text" name="unit" value="{{ request('unit') }}" placeholder="Asal Unit / Pengirim..." 
                               class="w-full px-5 py-3.5 bg-slate-50 dark:bg-neutral-800 border-none rounded-2xl text-xs font-bold focus:ring-2 focus:ring-brandTeal/20 transition-all">
                        <select name="sifat" class="w-full px-5 py-3.5 bg-slate-50 dark:bg-neutral-800 border-none rounded-2xl text-[10px] font-black uppercase tracking-wider focus:ring-2 focus:ring-brandTeal/20 transition-all cursor-pointer">
                            <option value="">Pilih Sifat Surat</option>
                            @foreach(['Rahasia', 'Penting', 'Disegerakan'] as $s)
                                <option value="{{ $s }}" {{ request('sifat') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Col 2: Financial Range --}}
                <div class="space-y-4">
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.15em] text-slate-400">
                        <span class="w-1 h-1 rounded-full bg-brandTeal"></span> Estimasi Nominal
                    </label>
                    <div class="flex items-center gap-3">
                        <div class="relative flex-1">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[9px] font-black text-slate-400">Rp</span>
                            <input type="number" name="min_nominal" value="{{ request('min_nominal') }}" placeholder="Min" 
                                   class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-neutral-800 border-none rounded-2xl text-xs font-bold focus:ring-2 focus:ring-brandTeal/20 transition-all">
                        </div>
                        <span class="text-slate-300">/</span>
                        <div class="relative flex-1">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[9px] font-black text-slate-400">Rp</span>
                            <input type="number" name="max_nominal" value="{{ request('max_nominal') }}" placeholder="Max" 
                                   class="w-full pl-10 pr-4 py-3.5 bg-slate-50 dark:bg-neutral-800 border-none rounded-2xl text-xs font-bold focus:ring-2 focus:ring-brandTeal/20 transition-all">
                        </div>
                    </div>
                </div>

                {{-- Col 3: Timeline --}}
                <div class="space-y-4">
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.15em] text-slate-400">
                        <span class="w-1 h-1 rounded-full bg-brandTeal"></span> Rentang Waktu
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative group">
                            <i class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-brandTeal">calendar_today</i>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                   class="w-full pl-11 pr-3 py-3.5 bg-slate-50 dark:bg-neutral-800 border-none rounded-2xl text-xs font-bold focus:ring-2 focus:ring-brandTeal/20 text-slate-500">
                        </div>
                        <div class="relative group">
                            <i class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-brandTeal">event_repeat</i>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                   class="w-full pl-11 pr-3 py-3.5 bg-slate-50 dark:bg-neutral-800 border-none rounded-2xl text-xs font-bold focus:ring-2 focus:ring-brandTeal/20 text-slate-500">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Filter (Reset) --}}
            @if(request()->anyFilled(['search', 'unit', 'min_nominal', 'max_nominal', 'date_from', 'date_to', 'status', 'sifat']))
            <div class="mt-4 py-3 flex justify-center border-t border-slate-50 dark:border-neutral-800/50">
                <a href="{{ route('surat.index') }}" class="group text-[10px] font-black text-rose-500 uppercase tracking-[0.2em] flex items-center gap-2 hover:text-rose-600 transition-all">
                    <i class="material-symbols-outlined text-sm group-hover:rotate-180 transition-transform duration-500">restart_alt</i> 
                    Reset Semua Parameter
                </a>
            </div>
            @endif
        </div>
    </form>
</div>

    {{-- Table Section --}}
    <div class="bg-white dark:bg-neutral-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto no-scrollbar">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-neutral-800/50">
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">No.</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Identitas Surat</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Asal & Tujuan</th>
                        <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Nominal</th>
                        <th class="px-8 py-5 text-center text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Sifat & Status</th>
                        <th class="px-8 py-5 text-center text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-neutral-800">
                    @forelse($surat as $index => $item)
                    <tr class="hover:bg-teal-50/30 dark:hover:bg-brandTeal/5 transition-all group">
                        <td class="px-8 py-6 text-sm font-bold text-slate-300 dark:text-neutral-600">
                            {{ sprintf('%02d', ($surat->currentPage() - 1) * $surat->perPage() + $index + 1) }}
                        </td>
                        
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-brandDark dark:text-white group-hover:text-brandTeal transition-colors truncate max-w-[200px]">
                                    {{ $item->nomor_surat ?? 'UNREG-DOC' }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-400 dark:text-neutral-500 mt-1.5 flex items-center gap-1.5">
                                    <i class="material-symbols-outlined text-[14px]">event_note</i>
                                    {{ $item->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-md bg-slate-100 dark:bg-neutral-800 flex items-center justify-center text-[10px] text-slate-500 font-black">F</div>
                                    <span class="text-xs font-bold text-slate-600 dark:text-neutral-300">{{ $item->pengirim->name }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="material-symbols-outlined text-[16px] text-brandTeal">arrow_right_alt</i>
                                    <span class="text-[10px] font-black text-brandTeal uppercase tracking-tighter">{{ $item->unitTujuan->nama_unit ?? 'DIREKSI' }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <div class="inline-flex items-center px-3 py-1 bg-slate-50 dark:bg-neutral-800 rounded-lg border border-slate-100 dark:border-neutral-700">
                                <span class="text-[11px] font-black text-brandDark dark:text-neutral-200">
                                    <span class="text-brandTeal mr-1">Rp</span>{{ number_format($item->nominal, 0, ',', '.') }}
                                </span>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <div class="flex flex-col items-center gap-2">
                                {{-- Sifat Badge --}}
                                @php
                                    $sifatClass = match($item->sifat) {
                                        'Rahasia' => 'bg-rose-50 text-rose-600 border-rose-100 dark:bg-rose-900/20',
                                        'Penting' => 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/20',
                                        default => 'bg-teal-50 text-teal-600 border-teal-100 dark:bg-brandTeal/10',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-md text-[9px] font-black border uppercase tracking-widest {{ $sifatClass }}">
                                    {{ $item->sifat }}
                                </span>

                                {{-- Status Badge --}}
                                @php
                                    $statusColor = match($item->status) {
                                        'Menunggu' => 'bg-amber-500',
                                        'Diproses' => 'bg-brandTeal',
                                        'Disetujui' => 'bg-emerald-500',
                                        'Ditolak' => 'bg-rose-500',
                                        default => 'bg-slate-400',
                                    };
                                @endphp
                                <span class="flex items-center gap-1.5 text-[10px] font-black text-slate-500 dark:text-neutral-400 uppercase tracking-tighter">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusColor }} shadow-[0_0_5px_rgba(0,0,0,0.1)]"></span>
                                    {{ $item->status }}
                                </span>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex justify-center items-center gap-1">
                                <a href="{{ route('surat.show', $item->id) }}" class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-brandTeal hover:bg-brandTeal/10 rounded-xl transition-all" title="Detail Dokumen">
                                    <i class="material-symbols-outlined text-xl">quick_reference_all</i>
                                </a>
                                
                                @if(Auth::user()->hasPermissionTo('surat-edit') && $item->pengirim_id == Auth::id())
                                    <a href="{{ route('surat.edit', $item->id) }}" class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-brandOrange hover:bg-brandOrange/10 rounded-xl transition-all" title="Edit Data">
                                        <i class="material-symbols-outlined text-xl">edit_note</i>
                                    </a>
                                @endif

                                @if(Auth::user()->hasPermissionTo('surat-delete') && $item->pengirim_id == Auth::id())
                                    <form action="{{ route('surat.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/20 rounded-xl transition-all" 
                                                onclick="return confirm('Hapus dokumen ini secara permanen?')">
                                            <i class="material-symbols-outlined text-xl">delete_sweep</i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-slate-50 dark:bg-neutral-800 rounded-[2rem] flex items-center justify-center mb-6 rotate-6 group">
                                    <i class="material-symbols-outlined text-5xl text-slate-200 dark:text-neutral-700 group-hover:rotate-12 transition-transform">folder_off</i>
                                </div>
                                <h3 class="text-lg font-black text-brandDark dark:text-white uppercase tracking-widest">Arsip Kosong</h3>
                                <p class="text-slate-400 dark:text-neutral-500 text-sm mt-2 font-medium">Tidak ada data surat yang sesuai dengan kriteria filter.</p>
                                <a href="{{ route('surat.index') }}" class="mt-6 px-6 py-2 bg-brandTeal/10 text-brandTeal text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-brandTeal hover:text-white transition-all">Reset Filter</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Section --}}
        <div class="px-10 py-8 bg-slate-50/50 dark:bg-neutral-800/50 border-t border-slate-50 dark:border-neutral-800">
            {{ $surat->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection