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

    {{-- Filter Section --}}
    <div class="bg-white dark:bg-neutral-900 rounded-[2rem] shadow-sm border border-slate-100 dark:border-neutral-800 p-3 overflow-x-auto no-scrollbar">
        <form method="GET" action="{{ route('surat.index') }}" class="flex items-center gap-2 min-w-max">
            <input type="hidden" name="filter" value="status">
            
            <button type="submit" name="status" value="" 
                class="px-6 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all {{ !request('status') ? 'bg-brandDark dark:bg-brandTeal text-white shadow-lg' : 'text-slate-400 dark:text-neutral-500 hover:bg-slate-50 dark:hover:bg-neutral-800' }}">
                Semua
            </button>

            @foreach([
                'Menunggu' => 'bg-amber-500', 
                'Diproses' => 'bg-brandTeal', 
                'Disetujui' => 'bg-emerald-500', 
                'Ditolak' => 'bg-rose-500', 
                'Selesai' => 'bg-brandDark'
            ] as $status => $color)
                <button type="submit" name="status" value="{{ $status }}" 
                    class="px-6 py-2.5 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all flex items-center gap-2 {{ request('status') == $status ? $color . ' text-white shadow-lg' : 'text-slate-400 dark:text-neutral-500 hover:bg-slate-50 dark:hover:bg-neutral-800' }}">
                    <span class="w-2 h-2 rounded-full {{ request('status') == $status ? 'bg-white' : $color }}"></span>
                    {{ $status }}
                </button>
            @endforeach
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