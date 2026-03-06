@extends('layouts.app')

@section('title', 'Detail Surat')

@section('content')
{{-- Header Section --}}
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div class="space-y-1">
        <div class="flex items-center gap-2 mb-2">
            <span class="px-3 py-1 bg-brandTeal/10 text-brandTeal text-[10px] font-black uppercase tracking-[0.2em] rounded-full">EDOC - Detail View</span>
        </div>
        <h1 class="text-4xl font-black text-brandDark tracking-tight italic uppercase">Detail <span class="text-brandTeal">Surat</span></h1>
        <p class="text-slate-400 font-medium text-sm">Kelola dan tinjau arsip digital surat masuk & keluar secara real-time.</p>
    </div>
    
    <a href="{{ route('surat.index') }}" class="group inline-flex items-center px-6 py-3 bg-white border-2 border-slate-100 rounded-2xl font-black text-xs text-slate-500 uppercase tracking-widest hover:border-brandTeal hover:text-brandTeal shadow-sm transition-all active:scale-95">
        <span class="material-symbols-outlined mr-2 text-lg transition-transform group-hover:-translate-x-1">arrow_back</span>
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    {{-- Sisi Kiri: Detail & Timeline --}}
    <div class="lg:col-span-2 space-y-8">
        {{-- Card Informasi Utama --}}
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                <h3 class="font-black text-brandDark uppercase tracking-widest text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-brandTeal">description</span>
                    Arsip Data Surat
                </h3>
                <span class="text-[10px] font-mono text-slate-400">UID: {{ $surat->id }}</span>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-12">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Nomor Dokumen</label>
                        <p class="text-sm font-black text-brandTeal bg-brandTeal/5 px-3 py-2 rounded-xl border border-brandTeal/10 inline-block tracking-tighter">
                            {{ $surat->nomor_surat ?? 'UNREG-000' }}
                        </p>
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Sifat Urgensi</label>
                        <div class="flex items-center gap-2 mt-1">
                            @php
                                $sifatStyle = match($surat->sifat) {
                                    'Rahasia' => 'bg-red-500 text-white shadow-red-200',
                                    'Penting' => 'bg-brandOrange text-white shadow-orange-200',
                                    default => 'bg-brandTeal text-white shadow-teal-200',
                                };
                            @endphp
                            <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg {{ $sifatStyle }}">
                                {{ $surat->sifat }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Identitas Pengirim</label>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-black text-slate-400 text-xs border-2 border-white shadow-sm">
                                {{ substr($surat->pengirim->name, 0, 2) }}
                            </div>
                            <p class="text-sm font-black text-slate-700">{{ $surat->pengirim->name }}</p>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Unit Destinasi</label>
                        <p class="text-sm font-black text-slate-700 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-brandTeal">apartment</span>
                            {{ $surat->unitTujuan->nama_unit ?? 'General Office' }}
                        </p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Anggaran/Nominal</label>
                        <p class="text-2xl font-black text-brandDark tracking-tighter">
                            <span class="text-sm text-brandTeal font-bold">Rp</span> {{ number_format($surat->nominal, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Timestamp Registrasi</label>
                        <p class="text-sm font-bold text-slate-500 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $surat->created_at->format('d M Y • H:i') }}
                        </p>
                    </div>
                </div>
                
                @if($surat->catatan)
                <div class="mt-10 pt-8 border-t border-dashed border-slate-200">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Memo Pengirim</label>
                    <div class="mt-3 p-5 bg-slate-50/80 rounded-2xl text-slate-600 text-sm font-medium leading-relaxed italic border-l-4 border-brandTeal shadow-inner">
                        "{{ $surat->catatan }}"
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Timeline Approval --}}
        @if($surat->approval->count() > 0)
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white p-8">
            <h3 class="font-black text-brandDark uppercase tracking-[0.2em] text-xs mb-8 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-brandOrange/10 text-brandOrange flex items-center justify-center">
                    <span class="material-symbols-outlined text-lg">history</span>
                </span>
                Log Approval & Tracking
            </h3>
            
            <div class="relative pl-8 border-l-2 border-slate-100 space-y-10 ml-4">
                @foreach($surat->approval as $approval)
                <div class="relative">
                    {{-- Dot Status --}}
                    @php
                        $color = match($approval->status) {
                            'Disetujui' => 'bg-green-500',
                            'Ditolak' => 'bg-red-500',
                            default => 'bg-brandOrange',
                        };
                    @endphp
                    <span class="absolute -left-[41px] top-0 w-5 h-5 rounded-full border-4 border-white shadow-lg {{ $color }}"></span>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-black text-brandDark uppercase tracking-tight">
                                {{ $approval->approver->name }}
                            </p>
                            <p class="text-[11px] font-bold text-slate-400 uppercase mt-0.5">
                                Mengubah Status Ke: <span class="text-brandTeal">{{ $approval->status }}</span>
                            </p>
                        </div>
                        <time class="text-[10px] font-black text-slate-300 bg-slate-50 px-3 py-1 rounded-full whitespace-nowrap">
                            {{ $approval->updated_at->diffForHumans() }}
                        </time>
                    </div>
                    
                    @if($approval->catatan)
                    <div class="mt-3 p-4 bg-slate-50 rounded-xl border border-slate-100 text-xs font-semibold text-slate-500 leading-relaxed shadow-sm">
                        {{ $approval->catatan }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Sisi Kanan: Status & Actions --}}
    <div class="space-y-6">
        {{-- Card Status --}}
        <div class="bg-brandDark rounded-[2rem] shadow-2xl shadow-brandDark/20 overflow-hidden text-center p-8 relative">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-4">Current Condition</label>
            
            @php
                $statusColor = match($surat->status) {
                    'Menunggu' => 'text-brandOrange bg-brandOrange/10 border-brandOrange/20',
                    'Diproses' => 'text-blue-400 bg-blue-400/10 border-blue-400/20',
                    'Disetujui' => 'text-brandTeal bg-brandTeal/10 border-brandTeal/20',
                    default => 'text-red-400 bg-red-400/10 border-red-400/20',
                };
            @endphp
            
            <div class="inline-block px-8 py-3 rounded-2xl border font-black text-xl uppercase tracking-tighter shadow-inner {{ $statusColor }}">
                {{ $surat->status }}
            </div>
            
            <div class="mt-8 pt-8 border-t border-white/10">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-4">File Lampiran</label>
                <a href="{{ asset('storage/surat/' . $surat->file) }}" target="_blank" 
                   class="flex flex-col items-center p-6 bg-white/5 border border-white/10 rounded-3xl hover:bg-white/10 transition-all group">
                    <span class="material-symbols-outlined text-4xl text-red-500 mb-3 group-hover:scale-110 transition-transform">picture_as_pdf</span>
                    <p class="text-[10px] font-black text-white uppercase tracking-widest truncate w-full text-center">{{ $surat->file }}</p>
                    <span class="text-[9px] font-bold text-brandTeal mt-2 group-hover:underline italic">Klik untuk melihat file &rarr;</span>
                </a>
            </div>
        </div>

        {{-- Card Aksi --}}
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white p-8">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 text-center">Tindakan Lanjutan</h3>
            <div class="grid grid-cols-1 gap-4">
                
                @if(Auth::user()->hasPermissionTo('surat-edit') && $surat->pengirim_id == Auth::id() && $surat->status == 'Menunggu')
                    <a href="{{ route('surat.edit', $surat->id) }}" class="flex justify-center items-center gap-3 px-6 py-4 bg-slate-100 text-slate-700 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-brandTeal hover:text-white transition-all shadow-sm">
                        <span class="material-symbols-outlined text-lg">edit_note</span> Koreksi Data
                    </a>
                @endif

                @if(Auth::user()->hasRole('Pengadaan') && $surat->status == 'Menunggu')
                    <form action="{{ route('surat.proses', $surat->id) }}" method="POST" onsubmit="return confirm('Proses dokumen ini sekarang?')">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center gap-3 px-6 py-4 bg-brandTeal text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:shadow-lg hover:shadow-teal-500/30 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-lg">sync_saved_locally</span> Proses Sekarang
                        </button>
                    </form>
                @endif

                @if(Auth::user()->hasRole('Direktur') && $surat->approval->where('approver_id', Auth::id())->where('status', 'Menunggu')->count() > 0)
                    <button onclick="toggleModal('approve-form')" class="w-full flex justify-center items-center gap-3 px-6 py-4 bg-brandTeal text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:shadow-lg hover:shadow-teal-500/40 transition-all">
                        <span class="material-symbols-outlined text-lg">verified</span> Beri Persetujuan
                    </button>
                    <button onclick="toggleModal('reject-form')" class="w-full flex justify-center items-center gap-3 px-6 py-4 bg-white text-red-500 border-2 border-red-50 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-50 transition-all">
                        <span class="material-symbols-outlined text-lg">cancel</span> Tolak Pengajuan
                    </button>
                @endif

                @if(Auth::user()->hasPermissionTo('surat-delete') && $surat->pengirim_id == Auth::id())
                    <form action="{{ route('surat.destroy', $surat->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Peringatan! Data yang dihapus tidak dapat dipulihkan. Lanjutkan?')" class="w-full mt-4 text-[10px] font-black text-red-300 hover:text-red-500 uppercase tracking-widest transition-colors py-2">
                             Musnahkan Dokumen
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modals --}}
<div id="approve-form" class="hidden mt-8 animate-fade-in-down">
    <div class="bg-teal-50 border-2 border-brandTeal/20 rounded-[2rem] p-8 shadow-2xl">
        <h4 class="text-brandDark font-black mb-6 flex items-center gap-3 uppercase tracking-tighter text-xl">
            <span class="material-symbols-outlined text-brandTeal text-3xl">task_alt</span> 
            Konfirmasi <span class="text-brandTeal">Persetujuan</span>
        </h4>
        <form action="{{ route('approval.approve', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Memo Persetujuan</label>
                    <textarea name="catatan" rows="3" class="w-full rounded-2xl border-white focus:ring-4 focus:ring-brandTeal/10 p-4 text-sm font-medium shadow-inner" placeholder="Tulis instruksi tambahan jika ada..."></textarea>
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Lampiran Tambahan</label>
                    <div class="relative w-full h-24 border-2 border-dashed border-brandTeal/20 rounded-2xl flex items-center justify-center bg-white/50 group">
                        <input type="file" name="file_catatan" class="absolute inset-0 opacity-0 cursor-pointer">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-brandTeal">upload_file</span>
                            <p class="text-[9px] font-bold text-slate-400 uppercase">Klik atau drop file di sini</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-4">
                <button type="button" onclick="toggleModal('approve-form')" class="px-6 py-2 text-xs font-black text-slate-400 uppercase tracking-widest">Batal</button>
                <button type="submit" class="px-10 py-4 bg-brandTeal text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-teal-500/30 active:scale-95 transition-all">Kirim Persetujuan</button>
            </div>
        </form>
    </div>
</div>

{{-- Script & Style --}}
<script>
    function toggleModal(id) {
        const el = document.getElementById(id);
        const forms = ['approve-form', 'reject-form'];
        
        forms.forEach(formId => {
            if(formId !== id) document.getElementById(formId).classList.add('hidden');
        });

        el.classList.toggle('hidden');
        if (!el.classList.contains('hidden')) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
</script>

<style>
    .animate-fade-in-down {
        animation: fadeInDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px) scale(0.98); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endsection