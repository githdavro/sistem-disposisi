@extends('layouts.app')

@section('title', 'Detail Surat')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Surat</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola dan tinjau informasi detail surat masuk/keluar.</p>
    </div>
    <a href="{{ route('surat.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
        <i class="fas fa-arrow-left mr-2 text-gray-400"></i> Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800">Informasi Surat</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nomor Surat</label>
                        <p class="mt-1 text-sm font-mono text-indigo-700 bg-indigo-50 px-2 py-1 rounded inline-block border border-indigo-100">
                            {{ $surat->nomor_surat ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Sifat Surat</label>
                        <div class="mt-1">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $surat->sifat == 'Rahasia' ? 'bg-red-100 text-red-700' : 
                                   ($surat->sifat == 'Penting' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ $surat->sifat }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengirim</label>
                        <p class="mt-1 text-gray-900 font-medium">{{ $surat->pengirim->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Unit Tujuan</label>
                        <p class="mt-1 text-gray-900 font-medium">{{ $surat->unitTujuan->nama_unit ?? 'Pengadaan' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nominal</label>
                        <p class="mt-1 text-lg font-bold text-gray-900">Rp {{ number_format($surat->nominal, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal Kirim</label>
                        <p class="mt-1 text-gray-600 text-sm">{{ $surat->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                
                @if($surat->catatan)
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Catatan Pengirim</label>
                    <div class="mt-2 p-4 bg-gray-50 rounded-lg text-gray-700 text-sm italic border-l-4 border-gray-300">
                        "{{ $surat->catatan }}"
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            @if($surat->approval->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-history mr-2 text-indigo-500"></i> Riwayat Approval
                </h3>
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($surat->approval as $index => $approval)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                            {{ $approval->status == 'Disetujui' ? 'bg-green-500' : ($approval->status == 'Ditolak' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                            <i class="fas {{ $approval->status == 'Disetujui' ? 'fa-check' : ($approval->status == 'Ditolak' ? 'fa-times' : 'fa-clock') }} text-white text-xs"></i>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $approval->approver->name }} 
                                            <span class="font-normal text-gray-500">mengubah status menjadi</span> 
                                            <span class="font-bold underline">{{ $approval->status }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5 italic">{{ $approval->updated_at->diffForHumans() }}</p>
                                        @if($approval->catatan)
                                            <p class="mt-2 text-sm text-gray-600 bg-gray-50 p-2 rounded border border-gray-100">{{ $approval->catatan }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 text-center border-b border-gray-100">
                <label class="text-xs font-semibold text-gray-400 uppercase block mb-2">Status Saat Ini</label>
                <span class="px-4 py-1.5 rounded-full text-sm font-bold shadow-sm
                    {{ $surat->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                       ($surat->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 
                       ($surat->status == 'Disetujui' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                    {{ $surat->status }}
                </span>
            </div>
            <div class="p-6 bg-gray-50/50">
                <label class="text-xs font-semibold text-gray-400 uppercase block mb-3">Dokumen Lampiran</label>
                <a href="{{ asset('storage/surat/' . $surat->file) }}" target="_blank" 
                   class="group flex items-center p-3 bg-white border border-gray-200 rounded-lg hover:border-indigo-300 hover:shadow-md transition-all">
                    <div class="bg-red-50 p-2 rounded-lg group-hover:bg-red-100 transition-colors">
                        <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $surat->file }}</p>
                        <p class="text-xs text-blue-600 font-semibold">Buka Dokumen &rarr;</p>
                    </div>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-widest">Aksi Tersedia</h3>
            <div class="grid grid-cols-1 gap-3">
                
                @if(Auth::user()->hasPermissionTo('surat-edit') && $surat->pengirim_id == Auth::id() && $surat->status == 'Menunggu')
                    <a href="{{ route('surat.edit', $surat->id) }}" class="w-full flex justify-center items-center px-4 py-2.5 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition shadow-sm">
                        <i class="fas fa-edit mr-2 text-indigo-200"></i> Edit Surat
                    </a>
                @endif

                @if(Auth::user()->hasRole('Pengadaan') && $surat->status == 'Menunggu')
                    <form action="{{ route('surat.proses', $surat->id) }}" method="POST" onsubmit="return confirm('Proses surat ini?')">
                        @csrf
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition shadow-sm">
                            <i class="fas fa-cog mr-2 text-blue-200"></i> Proses Sekarang
                        </button>
                    </form>
                @endif

                @if(Auth::user()->hasRole('Direktur') && $surat->approval->where('approver_id', Auth::id())->where('status', 'Menunggu')->count() > 0)
                    <button onclick="toggleModal('approve-form')" class="w-full flex justify-center items-center px-4 py-2.5 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition shadow-sm">
                        <i class="fas fa-check-circle mr-2 text-green-200"></i> Setujui
                    </button>
                    <button onclick="toggleModal('reject-form')" class="w-full flex justify-center items-center px-4 py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-lg font-bold hover:bg-red-100 transition">
                        <i class="fas fa-times-circle mr-2"></i> Tolak Surat
                    </button>
                @endif

                @if(Auth::user()->hasPermissionTo('surat-delete') && $surat->pengirim_id == Auth::id())
                    <form action="{{ route('surat.destroy', $surat->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus permanen surat ini?')" class="w-full text-xs text-red-400 hover:text-red-600 font-medium py-2 transition text-center underline">
                             Hapus Surat
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="approve-form" class="hidden mt-8 animate-fade-in-down">
    <div class="bg-green-50 border border-green-200 rounded-xl p-6 shadow-inner">
        <h4 class="text-green-800 font-bold mb-4 flex items-center">
            <i class="fas fa-check-double mr-2"></i> Konfirmasi Persetujuan Direktur
        </h4>
        <form action="{{ route('approval.approve', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-green-700 mb-1">Catatan Opsional</label>
                    <textarea name="catatan" rows="2" class="w-full rounded-lg border-green-200 focus:ring-green-500 focus:border-green-500 p-3 text-sm" placeholder="Tambahkan pesan..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-green-700 mb-1">Lampiran Pendukung</label>
                    <input type="file" name="file_catatan" class="w-full text-sm text-green-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-600 file:text-white hover:file:bg-green-700">
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button type="button" onclick="toggleModal('approve-form')" class="px-4 py-2 text-sm font-medium text-green-700">Batal</button>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg font-bold shadow-md hover:bg-green-700">Kirim Persetujuan</button>
            </div>
        </form>
    </div>
</div>

<div id="reject-form" class="hidden mt-8 animate-fade-in-down">
    <div class="bg-red-50 border border-red-200 rounded-xl p-6 shadow-inner">
        <h4 class="text-red-800 font-bold mb-4 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i> Alasan Penolakan
        </h4>
        <form action="{{ route('approval.reject', $surat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-red-700 mb-1 text-sm">Catatan Penolakan <span class="text-red-500">*</span></label>
                    <textarea name="catatan" rows="2" class="w-full rounded-lg border-red-200 focus:ring-red-500 focus:border-red-500 p-3 text-sm" required placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('reject-form')" class="px-4 py-2 text-sm font-medium text-red-700">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg font-bold shadow-md hover:bg-red-700 text-sm">Tolak Surat Sekarang</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        const el = document.getElementById(id);
        el.classList.toggle('hidden');
        if (!el.classList.contains('hidden')) {
            el.scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>

<style>
    .animate-fade-in-down {
        animation: fadeInDown 0.3s ease-out;
    }
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection