@extends('layouts.app')

@section('title', 'Buat Surat Baru')

@section('content')
{{-- Header Section --}}
<div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div class="space-y-1">
        <div class="flex items-center gap-2 mb-2">
            <span class="px-3 py-1 bg-brandTeal/10 text-brandTeal text-[10px] font-black uppercase tracking-[0.2em] rounded-full">Entry Form</span>
        </div>
        <h1 class="text-4xl font-black text-brandDark tracking-tight italic uppercase">Registrasi <span class="text-brandTeal">Surat</span></h1>
        <p class="text-slate-400 font-medium text-sm">Silahkan lengkapi atribut dokumen untuk memulai proses workflow digital.</p>
    </div>
    
    <a href="{{ route('surat.index') }}" class="group inline-flex items-center px-6 py-3 bg-white border-2 border-slate-100 rounded-2xl font-black text-xs text-slate-500 uppercase tracking-widest hover:border-brandTeal hover:text-brandTeal shadow-sm transition-all active:scale-95">
        <span class="material-symbols-outlined mr-2 text-lg transition-transform group-hover:-translate-x-1">arrow_back</span>
        Daftar Surat
    </a>
</div>

<div class="w-full mx-auto">
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-white overflow-hidden relative">
        {{-- Progress Decorative Bar --}}
        <div class="absolute top-0 left-0 w-full h-1.5 bg-slate-50">
            <div class="h-full bg-brandTeal w-1/3 shadow-[0_0_10px_rgba(20,184,166,0.5)]"></div>
        </div>

        <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data" class="relative p-8 md:p-12">
            @csrf
            
            <div class="space-y-8">
                {{-- Grid Input --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Unit Tujuan --}}
                    <div class="space-y-2">
                        <label for="unit_tujuan_id" class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">
                            <span class="material-symbols-outlined text-sm text-brandTeal">apartment</span>
                            Destinasi Unit <span class="text-brandOrange">*</span>
                        </label>
                        <div class="relative">
                            <select id="unit_tujuan_id" name="unit_tujuan_id" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-700 focus:bg-white focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all outline-none appearance-none cursor-pointer" required>
                                <option value="">Pilih Unit Tujuan</option>
                                @foreach($unit as $u)
                                    <option value="{{ $u->id }}" {{ old('unit_tujuan_id') == $u->id ? 'selected' : '' }}>{{ $u->nama_unit }}</option>
                                @endforeach
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                        </div>
                        @error('unit_tujuan_id') <p class="text-red-500 text-[10px] font-bold mt-1 ml-2 uppercase">{{ $message }}</p> @enderror
                    </div>

                    {{-- Sifat Surat --}}
                    <div class="space-y-2">
                        <label for="sifat" class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">
                            <span class="material-symbols-outlined text-sm text-brandTeal">label_important</span>
                            Tingkat Urgensi <span class="text-brandOrange">*</span>
                        </label>
                        <div class="relative">
                            <select id="sifat" name="sifat" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-4 py-3.5 text-sm font-bold text-slate-700 focus:bg-white focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all outline-none appearance-none cursor-pointer" required>
                                <option value="">Pilih Sifat</option>
                                <option value="Rahasia" {{ old('sifat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                                <option value="Penting" {{ old('sifat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                                <option value="Disegerakan" {{ old('sifat') == 'Disegerakan' ? 'selected' : '' }}>Disegerakan</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                        </div>
                    </div>

                    {{-- Nominal --}}
                    <div class="md:col-span-2 space-y-2">
                        <label for="nominal" class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">
                            <span class="material-symbols-outlined text-sm text-brandTeal">payments</span>
                            Estimasi Nominal (Rp) <span class="text-brandOrange">*</span>
                        </label>
                        <div class="relative group">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-lg font-black text-brandTeal group-focus-within:text-brandOrange transition-colors">Rp</span>
                            <input type="number" id="nominal" name="nominal" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl pl-14 pr-4 py-5 text-2xl font-black text-brandDark focus:bg-white focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all outline-none placeholder:text-slate-200" placeholder="0" step="0.01" min="0" value="{{ old('nominal') }}" required>
                        </div>
                        <div class="flex items-center gap-2 px-2">
                            <span class="material-symbols-outlined text-[14px] text-brandOrange animate-pulse">info</span>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight italic">Sistem akan otomatis meneruskan ke Direktur jika nominal > 1.000.000</p>
                        </div>
                    </div>

                    {{-- Switch Lampiran --}}
                    <div class="md:col-span-2">
                        <label class="flex items-center group cursor-pointer w-fit inline-flex">
                            <div class="relative">
                                <input type="checkbox" id="pakai_file" class="sr-only peer">
                                <div class="w-12 h-6 bg-slate-200 rounded-full peer peer-checked:bg-brandTeal transition-all duration-300"></div>
                                <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-all duration-300 peer-checked:translate-x-6"></div>
                            </div>
                            <span class="ml-3 text-[11px] font-black text-slate-500 uppercase tracking-widest group-hover:text-brandTeal transition-colors">Lampirkan File Dokumen</span>
                        </label>
                    </div>

                    {{-- File Input Field (Hidden by Default) --}}
                    <div id="fileField" class="md:col-span-2 hidden animate-fade-in-down">
                        <div class="relative group">
                            <input type="file" id="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="bg-brandTeal/[0.02] border-2 border-dashed border-brandTeal/20 rounded-2xl p-10 flex flex-col items-center justify-center group-hover:border-brandTeal transition-all group-hover:bg-brandTeal/[0.05]">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl text-brandTeal">upload_file</span>
                                </div>
                                <p class="text-xs font-black text-slate-600 uppercase tracking-widest">Klik untuk unggah atau seret file</p>
                                <p class="text-[10px] text-slate-400 font-bold mt-2">PDF, DOC, DOCX (MAKSIMAL 2MB)</p>
                                <div id="fileNamePreview" class="mt-4 text-[10px] font-black text-brandOrange uppercase hidden"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div class="md:col-span-2 space-y-2">
                        <label for="catatan" class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] ml-1">
                            <span class="material-symbols-outlined text-sm text-brandTeal">notes</span>
                            Ringkasan / Catatan
                        </label>
                        <textarea id="catatan" name="catatan" rows="4" class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-4 text-sm font-medium text-slate-700 focus:bg-white focus:border-brandTeal focus:ring-4 focus:ring-brandTeal/10 transition-all outline-none" placeholder="Berikan gambaran singkat mengenai isi surat ini...">{{ old('catatan') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Footer Action --}}
            <div class="mt-12 pt-8 border-t border-slate-100 flex items-center justify-end">
                <button type="submit" class="w-full md:w-auto flex items-center justify-center gap-3 px-12 py-5 bg-brandDark text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-slate-200 hover:bg-brandTeal hover:shadow-teal-500/30 active:scale-95 transition-all group">
                    Simpan Surat
                    <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">send</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle File Field
    document.getElementById('pakai_file').addEventListener('change', function() {
        const fileField = document.getElementById('fileField');
        const fileInput = document.getElementById('file');

        if (this.checked) {
            fileField.classList.remove('hidden');
            fileField.classList.add('block');
            fileInput.required = true;
        } else {
            fileField.classList.add('hidden');
            fileField.classList.remove('block');
            fileInput.required = false;
            fileInput.value = '';
            document.getElementById('fileNamePreview').classList.add('hidden');
        }
    });

    // Preview File Name
    document.getElementById('file').addEventListener('change', function() {
        const fileName = this.files[0]?.name;
        const preview = document.getElementById('fileNamePreview');
        if (fileName) {
            preview.innerText = "Terpilih: " + fileName;
            preview.classList.remove('hidden');
        }
    });
</script>

<style>
    .animate-fade-in-down {
        animation: fadeInDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection