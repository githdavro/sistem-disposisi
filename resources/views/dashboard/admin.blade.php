@extends('layouts.app')

@section('title', 'Dashboard Admin | GPM')

@section('content')
<div class="space-y-8 pb-12">
    {{-- Hero Section --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-teal to-teal-50 dark:from-brandDark dark:to-brandDark rounded-[2.5rem] p-8 md:p-12 shadow-xl shadow-slate-200/60 dark:shadow-black/40 border border-white dark:border-teal-500/10 transition-all duration-500">
    
    <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 blur-[100px] opacity-30 dark:opacity-40 transition-opacity">
        <div class="h-64 w-64 rounded-full bg-brandTeal/40 dark:bg-brandTeal"></div>
    </div>
    <div class="absolute bottom-0 left-0 translate-y-12 -translate-x-12 blur-[80px] opacity-20 dark:opacity-10 transition-opacity">
        <div class="h-64 w-64 rounded-full bg-brandOrange/30 dark:bg-brandOrange"></div>
    </div>
    
    <div class="relative z-10">
        <h2 class="text-3xl md:text-5xl font-extrabold text-slate-800 dark:text-white tracking-tight">
            Selamat Datang, 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brandTeal to-teal-600 dark:to-teal-300">
                {{ Auth::user()->name }}
            </span>!
        </h2>
        
        <p class="mt-4 text-slate-600 dark:text-slate-400 max-w-2xl text-lg font-medium leading-relaxed">
            Panel administrasi internal 
            <span class="text-brandTeal font-bold">PT. Graha Perdana Medika</span>. 
            Pantau alur disposisi surat dan koordinasi antar unit secara real-time.
        </p>
    </div>
</div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Surat', 'value' => $totalSurat, 'icon' => 'inventory_2', 'color' => '#00A99D', 'bg' => 'teal'],
                ['label' => 'Disetujui', 'value' => $suratDisetujui, 'icon' => 'verified', 'color' => '#10b981', 'bg' => 'emerald'],
                ['label' => 'Ditolak', 'value' => $suratDitolak, 'icon' => 'gpp_bad', 'color' => '#f43f5e', 'bg' => 'rose'],
                ['label' => 'Menunggu', 'value' => $suratMenunggu, 'icon' => 'pending_actions', 'color' => '#f59e0b', 'bg' => 'amber'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="group bg-white dark:bg-neutral-900 rounded-3xl border border-gray-100 dark:border-neutral-800 p-6 shadow-sm hover:shadow-xl hover:shadow-teal-900/5 hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.15em]">{{ $stat['label'] }}</p>
                    <p class="text-4xl font-black text-brandDark dark:text-white mt-1">{{ $stat['value'] }}</p>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-neutral-800 group-hover:scale-110 transition-transform duration-500 shadow-inner" style="color: {{ $stat['color'] }}">
                    <span class="material-symbols-outlined text-3xl">{{ $stat['icon'] }}</span>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-slate-50 dark:border-neutral-800 flex items-center text-[10px] font-bold uppercase tracking-tighter text-slate-400">
                <span class="w-1.5 h-1.5 rounded-full bg-brandTeal mr-2 opacity-40 group-hover:opacity-100 transition-opacity"></span>
                <span>Update Terakhir: Baru saja</span>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Table Section --}}
    <div class="bg-white dark:bg-neutral-900 rounded-[2.5rem] border border-gray-100 dark:border-neutral-800 shadow-sm overflow-hidden" x-data="{ expanded: false }">
        <div class="p-8 border-b border-gray-50 dark:border-neutral-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-neutral-900">
            <div>
                <h2 class="text-xl font-extrabold text-brandDark dark:text-white flex items-center gap-3">
                    <span class="w-2 h-8 bg-brandTeal rounded-full"></span>
                    Statistik Surat per Unit
                </h2>
                <p class="text-sm text-slate-500 dark:text-neutral-400 mt-1 font-medium">Beban kerja administratif setiap departemen GPM</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="bg-teal-50 dark:bg-brandTeal/10 px-4 py-2 rounded-xl">
                    <span class="text-xs font-black text-brandTeal uppercase tracking-widest">{{ count($statistikPerUnit) }} Unit Terdaftar</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-left">
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-widest border-b border-gray-50 dark:border-neutral-800">Nama Unit Kerja</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-widest border-b border-gray-50 dark:border-neutral-800">Volume & Intensitas</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-widest border-b border-gray-50 dark:border-neutral-800 text-right">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-neutral-800">
                    @foreach($statistikPerUnit as $index => $unit)
                    <tr 
                        class="hover:bg-teal-50/30 dark:hover:bg-brandTeal/5 transition-colors group"
                        x-show="expanded || {{ $index }} < 5"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    >
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-neutral-800 flex items-center justify-center text-brandTeal font-black group-hover:bg-brandTeal group-hover:text-white transition-all duration-300 shadow-sm border border-slate-100 dark:border-neutral-700">
                                    {{ substr($unit->nama_unit, 0, 1) }}
                                </div>
                                <span class="font-bold text-slate-700 dark:text-neutral-200 group-hover:text-brandTeal transition-colors">{{ $unit->nama_unit }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-6">
                                <span class="text-xl font-black text-brandDark dark:text-white w-10 tracking-tighter">{{ $unit->surat_tujuan_count }}</span>
                                <div class="flex-1 max-w-[200px] h-2 bg-slate-100 dark:bg-neutral-800 rounded-full overflow-hidden border border-slate-50 dark:border-neutral-700">
                                    @php 
                                        $percentage = ($totalSurat > 0) ? ($unit->surat_tujuan_count / $totalSurat) * 100 : 0;
                                    @endphp
                                    <div class="h-full bg-gradient-to-r from-brandTeal to-teal-400 rounded-full transition-all duration-1000 shadow-[0_0_8px_rgba(0,169,157,0.4)]" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button class="w-10 h-10 rounded-full inline-flex items-center justify-center text-slate-300 group-hover:text-brandOrange group-hover:bg-orange-50 dark:group-hover:bg-brandOrange/10 transition-all transform group-hover:rotate-12">
                                <span class="material-symbols-outlined">trending_flat</span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Footer Tombol Expand --}}
        @if(count($statistikPerUnit) > 5)
        <div class="p-6 bg-slate-50/50 dark:bg-neutral-800/50 border-t border-gray-50 dark:border-neutral-800 text-center">
            <button 
                @click="expanded = !expanded" 
                class="inline-flex items-center gap-2 px-8 py-3 rounded-2xl bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-700 text-xs font-black text-slate-600 dark:text-neutral-300 hover:bg-brandTeal hover:text-white hover:border-brandTeal transition-all shadow-sm active:scale-95 uppercase tracking-widest"
            >
                <span x-text="expanded ? 'Sembunyikan' : 'Tampilkan Semua Unit'"></span>
                <span class="material-symbols-outlined transition-transform duration-300 text-sm" :class="expanded ? 'rotate-180' : ''">
                    keyboard_arrow_down
                </span>
            </button>
        </div>
        @endif

        @if($statistikPerUnit->isEmpty())
        <div class="p-20 text-center">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-[2rem] bg-teal-50 dark:bg-brandTeal/5 mb-6 rotate-12">
                <span class="material-symbols-outlined text-5xl text-brandTeal opacity-40">clinical_notes</span>
            </div>
            <p class="text-slate-400 dark:text-neutral-500 font-bold tracking-widest uppercase text-xs">Belum ada aktivitas surat terdeteksi</p>
        </div>
        @endif
    </div>
</div>
@endsection