@extends('layouts.app')

@section('title', 'Edit Surat')

@section('content')
{{-- Header Section --}}
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div class="space-y-1">
        <div class="flex items-center gap-2 mb-2">
            <span class="px-3 py-1 bg-brandOrange/10 text-brandOrange text-[10px] font-black uppercase tracking-[0.2em] rounded-full">Editor Mode</span>
        </div>
        <h1 class="text-4xl font-black text-brandDark tracking-tight italic uppercase">Revisi <span class="text-brandTeal">Dokumen</span></h1>
        <p class="text-slate-400 font-medium text-sm">Pastikan data yang diperbarui sudah sesuai dengan lampiran fisik surat.</p>
    </div>
    
    <a href="{{ route('surat.show', $surat->id) }}" class="group inline-flex items-center px-6 py-3 bg-white border-2 border-slate-100 rounded-2xl font-black text-xs text-slate-500 uppercase tracking-widest hover:border-brandTeal hover:text-brandTeal shadow-sm transition-all active:scale-95">
        <span class="material-symbols-outlined mr-2 text-lg transition-transform group-hover:-translate-x-1">arrow_back</span>
        Kembali
    </a>
</div>

<div class="w-full mx-auto">
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-white overflow-hidden relative">
        {{-- Dekorasi Latar --}}
        <div class="absolute top-0 right-0 w-32 h-32 bg-brandTeal/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
        
        <form action="{{ route('surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data" class="relative">
            @csrf
            @method('PUT')
            
            <div class="p-8 md:p-12 space-y-8">
                {{-- Grid Input --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Unit Tujuan --}}
                    <div class="space-y-2">
                        <label for="unit_tujuan_id" class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">
                            <span class="material-symbols-outlined text-sm text-brandTeal">apartment</span>
                            Unit Tujuan <span class="text-brandOrange">*</span>
                        </label>
                        <select id="unit_tujuan_id" name="unit_tujuan_id" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-700 focus:bg-white focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all outline-none appearance-none cursor-pointer" required>
                            <option value="">Pilih Unit Tujuan</option>
                            @foreach($unit as $u)
                                <option value="{{ $u->id }}" {{ $surat->unit_tujuan_id == $u->id ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                            @endforeach
                            <option value="pengadaan" {{ is_null($surat->unit_tujuan_id) ? 'selected' : '' }}>Pengadaan</option>
                        </select>
                        @error('unit_tujuan_id') <p class="text-red-500 text-[10px] font-bold mt-1 ml-2 uppercase">{{ $message }}</p> @enderror
                    </div>

                    {{-- Sifat Surat --}}
                    <div class="space-y-2">
                        <label for="sifat" class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">
                            <span class="material-symbols-outlined text-sm text-brandTeal">label_important</span>
                            Sifat Surat <span class="text-brandOrange">*</span>
                        </label>
                        <select id="sifat" name="sifat" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-700 focus:bg-white focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all outline-none appearance-none cursor-pointer" required>
                            <option value="Rahasia" {{ old('sifat', $surat->sifat) == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                            <option value="Penting" {{ old('sifat', $surat->sifat) == 'Penting' ? 'selected' : '' }}>Penting</option>
                            <option value="Disegerakan" {{ old('sifat', $surat->sifat) == 'Disegerakan' ? 'selected' : '' }}>Disegerakan</option>
                        </select>
                    </div>

                    {{-- Nominal --}}
                    <div class="md:col-span-2 space-y-2">
                        <label for="nominal" class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">
                            <span class="material-symbols-outlined text-sm text-brandTeal">payments</span>
                            Nominal (Rp) <span class="text-brandOrange">*</span>
                        </label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-black text-brandTeal group-focus-within:text-brandOrange transition-colors">Rp</span>
                            <input type="number" id="nominal" name="nominal" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl pl-12 pr-4 py-4 text-xl font-black text-brandDark focus:bg-white focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all outline-none" step="0.01" min="0" value="{{ old('nominal', $surat->nominal) }}" required>
                        </div>
                        <div class="flex items-center gap-2 px-2">
                            <span class="material-symbols-outlined text-[14px] text-brandOrange animate-pulse">info</span>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Nominal di atas 1.000.000 membutuhkan approval Direktur</p>
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div class="md:col-span-2 space-y-2">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">
                            <span class="material-symbols-outlined text-sm text-brandTeal">upload_file</span>
                            Update Dokumen Lampiran
                        </label>
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1 relative group">
                                <input type="file" id="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-6 flex flex-col items-center justify-center group-hover:border-brandTeal transition-all group-hover:bg-brandTeal/[0.02]">
                                    <span class="material-symbols-outlined text-2xl text-slate-300 group-hover:text-brandTeal mb-2">cloud_upload</span>
                                    <p class="text-[11px] font-black text-slate-400 uppercase group-hover:text-brandTeal">Pilih file baru atau seret ke sini</p>
                                    <p class="text-[9px] text-slate-300 font-bold mt-1">PDF, DOC, DOCX (MAKS. 2MB)</p>
                                </div>
                            </div>
                            {{-- Current File Info --}}
                            <div class="md:w-64 bg-slate-50 rounded-2xl p-4 flex flex-col justify-center border border-slate-100 shadow-inner">
                                <p class="text-[9px] font-black text-slate-400 uppercase mb-2">File Aktif saat ini:</p>
                                <a href="{{ asset('storage/surat/' . $surat->file) }}" target="_blank" class="flex items-center gap-2 group">
                                    <span class="material-symbols-outlined text-red-500">picture_as_pdf</span>
                                    <span class="text-[11px] font-bold text-slate-600 truncate group-hover:text-brandTeal underline underline-offset-4">{{ $surat->file }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div class="md:col-span-2 space-y-2">
                        <label for="catatan" class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">
                            <span class="material-symbols-outlined text-sm text-brandTeal">sticky_note_2</span>
                            Memo / Catatan Tambahan
                        </label>
                        <textarea id="catatan" name="catatan" rows="4" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-4 text-sm font-medium text-slate-700 focus:bg-white focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all outline-none" placeholder="Tuliskan keterangan tambahan mengenai revisi ini...">{{ old('catatan', $surat->catatan) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Action Footer --}}
            <div class="bg-slate-50/80 p-8 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest order-2 md:order-1">
                    Terakhir diubah: {{ $surat->updated_at->format('d/m/Y H:i') }}
                </p>
                
                <div class="flex items-center gap-3 w-full md:w-auto order-1 md:order-2">
                    <button type="submit" class="flex-1 md:flex-none flex items-center justify-center gap-3 px-10 py-4 bg-brandTeal text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-teal-500/30 hover:shadow-teal-500/50 active:scale-95 transition-all">
                        <span class="material-symbols-outlined text-lg">save</span>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Menghilangkan panah di input number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection