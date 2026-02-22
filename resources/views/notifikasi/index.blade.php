@extends('layouts.app')

@section('title', 'Notifikasi | GPM')

@section('content')
<div class="w-full space-y-8 pb-12">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-extrabold text-brandDark dark:text-white tracking-tight flex items-center gap-3">
                <span class="p-2 bg-brandOrange/10 text-brandOrange rounded-xl shrink-0">
                    <i class="material-symbols-outlined text-3xl">notifications_active</i>
                </span>
                Pusat Notifikasi
            </h1>
            <p class="text-slate-500 dark:text-neutral-400 mt-1 font-medium ml-14">Informasi terbaru mengenai aktivitas akun dan dokumen Anda.</p>
        </div>
        
        @if($notifikasi->count() > 0)
            <a href="{{ route('notifikasi.mark-all-read') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-brandDark dark:bg-brandTeal text-white text-[11px] font-black rounded-2xl transition-all transform active:scale-95 group uppercase tracking-widest shadow-lg shadow-teal-900/20">
                <span class="material-symbols-outlined mr-2 text-lg">done_all</span>
                Tandai Semua Dibaca
            </a>
        @endif
    </div>

    {{-- Content Section --}}
    <div class="bg-white dark:bg-neutral-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-neutral-800 overflow-hidden">
        @if($notifikasi->count() > 0)
            <div class="overflow-x-auto no-scrollbar">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-neutral-800/50">
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Info & Judul</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Isi Pesan</th>
                            <th class="px-8 py-5 text-center text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Waktu Detail</th>
                            <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 dark:text-neutral-500 uppercase tracking-[0.2em]">Aksi Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-neutral-800">
                        @foreach($notifikasi as $index => $notif)
                        <tr class="transition-all group {{ !$notif->dibaca ? 'bg-brandTeal/[0.03] dark:bg-brandTeal/[0.02]' : '' }}">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ !$notif->dibaca ? 'bg-brandTeal text-white shadow-lg shadow-teal-500/20' : 'bg-slate-100 dark:bg-neutral-800 text-slate-400' }}">
                                        <i class="material-symbols-outlined text-xl">{{ !$notif->dibaca ? 'mail' : 'drafts' }}</i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black {{ !$notif->dibaca ? 'text-brandDark dark:text-white' : 'text-slate-500' }}">
                                            {{ $notif->judul }}
                                        </span>
                                        @if(!$notif->dibaca)
                                            <span class="text-[9px] font-black text-brandOrange uppercase tracking-widest mt-0.5 italic">Baru</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <p class="text-sm {{ !$notif->dibaca ? 'text-slate-700 dark:text-neutral-200 font-bold' : 'text-slate-400 dark:text-neutral-500' }} leading-relaxed max-w-xs">
                                    {{ Str::limit($notif->pesan, 70) }}
                                </p>
                            </td>

                            <td class="px-8 py-6 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="text-[11px] font-black text-slate-700 dark:text-neutral-300">{{ $notif->created_at->format('d M Y') }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 dark:text-neutral-500 uppercase tracking-tighter">{{ $notif->created_at->format('H:i') }} WIB</span>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="flex justify-end items-center gap-3">
                                    {{-- Tombol Lihat (Solid) --}}
                                    <a href="{{ route('notifikasi.show', $notif->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-900 dark:bg-neutral-800 text-white dark:text-neutral-200 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-brandTeal transition-all shadow-md active:scale-95">
                                        <i class="material-symbols-outlined text-sm mr-2">visibility</i>
                                        Buka
                                    </a>
                                    
                                    {{-- Tombol Tandai Dibaca (Solid Emerald) --}}
                                    @if(!$notif->dibaca)
                                        <a href="{{ route('notifikasi.mark-read', $notif->id) }}" class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-md shadow-emerald-500/20 active:scale-95">
                                            <i class="material-symbols-outlined text-sm mr-2">check</i>
                                            Selesai
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- Fancy & Clean Empty State --}}
            <div class="py-32 flex flex-col items-center justify-center text-center px-6">
                <div class="relative mb-8">
                    <div class="absolute inset-0 rounded-full bg-brandTeal/20 animate-ping opacity-20"></div>
                    <div class="relative w-28 h-28 bg-gradient-to-tr from-slate-50 to-white dark:from-neutral-800 dark:to-neutral-900 rounded-[2.5rem] shadow-inner flex items-center justify-center border border-slate-100 dark:border-neutral-700">
                        <i class="material-symbols-outlined text-6xl text-slate-200 dark:text-neutral-700">notifications_off</i>
                    </div>
                </div>
                
                <h3 class="text-2xl font-black text-brandDark dark:text-white uppercase tracking-widest">Tidak Ada Notifikasi</h3>
                <p class="text-slate-400 dark:text-neutral-500 mt-3 max-w-sm font-medium leading-relaxed">
                    Arsip notifikasi Anda kosong. Segala pemberitahuan sistem di masa mendatang akan muncul di sini.
                </p>
                
                <div class="mt-10">
                    <a href="{{ route('dashboard') }}" class="px-8 py-3.5 bg-brandTeal text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-teal-600 transition-all shadow-xl shadow-teal-900/20">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection