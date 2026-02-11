@extends('layouts.app')

@section('title', 'Detail Surat')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail Surat</h1>
        <p class="text-gray-600">Lihat detail dan informasi surat</p>
    </div>
    <a href="{{ route('surat.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-lg font-semibold mb-4">Informasi Surat</h3>
            <div class="space-y-3">
                <div class="flex items-start">
                    <span class="font-medium w-1/3 pt-1">Nomor Surat:</span>
                    <span class="font-mono bg-gray-50 px-3 py-1 rounded-lg border">
                        {{ $surat->nomor_surat ?? '-' }}
                    </span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Pengirim:</span>
                    <span>{{ $surat->pengirim->name }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Unit Tujuan:</span>
                    <span>{{ $surat->unitTujuan->nama_unit ?? 'Pengadaan' }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Nominal:</span>
                    <span class="font-medium">Rp. {{ number_format($surat->nominal, 2, ',', '.') }}</span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Sifat:</span>
                    <span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $surat->sifat == 'Rahasia' ? 'bg-red-100 text-red-800' : 
                               ($surat->sifat == 'Penting' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-blue-100 text-blue-800') }}">
                            {{ $surat->sifat }}
                        </span>
                    </span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Status:</span>
                    <span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $surat->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                               ($surat->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 
                               ($surat->status == 'Disetujui' ? 'bg-green-100 text-green-800' : 
                               ($surat->status == 'Ditolak' ? 'bg-red-100 text-red-800' : 
                               'bg-gray-100 text-gray-800'))) }}">
                            {{ $surat->status }}
                        </span>
                    </span>
                </div>
                <div class="flex">
                    <span class="font-medium w-1/3">Tanggal Kirim:</span>
                    <span>{{ $surat->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @if($surat->updated_at != $surat->created_at)
                    <div class="flex">
                        <span class="font-medium w-1/3">Terakhir Diupdate:</span>
                        <span>{{ $surat->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>
        
        <div>
            <h3 class="text-lg font-semibold mb-4">Dokumen & Catatan</h3>
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <span class="font-medium block mb-2">File Surat:</span>
                    <a href="{{ asset('storage/surat/' . $surat->file) }}" target="_blank" 
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        <i class="fas fa-file-pdf mr-2 text-red-500"></i> 
                        {{ $surat->file }}
                        <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                    </a>
                    <p class="text-gray-500 text-xs mt-2">Klik untuk melihat atau download file</p>
                </div>
                
                @if($surat->catatan)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <span class="font-medium block mb-2">Catatan:</span>
                        <p class="text-gray-700 whitespace-pre-line">{{ $surat->catatan }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($surat->approval->count() > 0)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Riwayat Approval</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Approver
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Catatan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            File
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($surat->approval as $approval)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="font-medium">{{ $approval->approver->name }}</div>
                                        <div class="text-gray-500 text-sm">{{ $approval->approver->jabatan ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $approval->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($approval->status == 'Disetujui' ? 'bg-green-100 text-green-800' : 
                                       'bg-red-100 text-red-800') }}">
                                    {{ $approval->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $approval->catatan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($approval->file_catatan)
                                    <a href="{{ asset('storage/approval/' . $approval->file_catatan) }}" target="_blank" 
                                       class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-file-alt mr-1"></i> File
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $approval->updated_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@if($surat->disposisi->count() > 0)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Riwayat Disposisi</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pengirim
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Penerima
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Catatan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($surat->disposisi as $disposisi)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $disposisi->pengirim->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $disposisi->penerima->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $disposisi->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($disposisi->status == 'Diterima' ? 'bg-blue-100 text-blue-800' : 
                                       'bg-green-100 text-green-800') }}">
                                    {{ $disposisi->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $disposisi->catatan ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $disposisi->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Aksi</h3>
    <div class="flex flex-wrap gap-2">
        @if(Auth::user()->hasPermissionTo('surat-edit') && $surat->pengirim_id == Auth::id() && $surat->status == 'Menunggu')
            <a href="{{ route('surat.edit', $surat->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
        @endif
        
        @if(Auth::user()->hasRole('Pengadaan') && $surat->status == 'Menunggu')
    <form action="{{ route('surat.proses', $surat->id) }}"
          method="POST"
          class="inline"
          onsubmit="return confirm('Apakah Anda yakin ingin memproses surat ini?')">
        @csrf
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-check mr-2"></i> Proses
        </button>
    </form>
@endif
        
        @if(Auth::user()->hasRole('Pengadaan') && $surat->status == 'Disetujui')
            <a href="{{ route('surat.kirim-ke-unit', $surat->id) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin mengirim surat ini ke unit tujuan?')">
                <i class="fas fa-paper-plane mr-2"></i> Kirim ke Unit
            </a>
        @endif
        
        @if(Auth::user()->hasRole('Direktur') && $surat->approval->where('approver_id', Auth::id())->where('status', 'Menunggu')->count() > 0)
            <button onclick="document.getElementById('approve-form').style.display = 'block'" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-check mr-2"></i> Setujui
            </button>
            <button onclick="document.getElementById('reject-form').style.display = 'block'" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-times mr-2"></i> Tolak
            </button>
        @endif
        
        @if(Auth::user()->hasPermissionTo('surat-delete') && $surat->pengirim_id == Auth::id())
            <form action="{{ route('surat.destroy', $surat->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                    <i class="fas fa-trash mr-2"></i> Hapus
                </button>
            </form>
        @endif
    </div>
    
    @if(Auth::user()->hasRole('Direktur') && $surat->approval->where('approver_id', Auth::id())->where('status', 'Menunggu')->count() > 0)
        <!-- Approve Form -->
        <div id="approve-form" style="display: none;" class="mt-6 p-4 bg-green-50 rounded-lg">
            <h4 class="text-lg font-semibold mb-4">Setujui Surat</h4>
            <form action="{{ route('approval.approve', $surat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="approve-catatan" class="block text-gray-700 text-sm font-bold mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea id="approve-catatan" name="catatan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="approve-file" class="block text-gray-700 text-sm font-bold mb-2">
                        File Catatan (Opsional)
                    </label>
                    <input type="file" id="approve-file" name="file_catatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <p class="text-gray-500 text-xs mt-1">Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Maks. 2MB)</p>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="button" onclick="document.getElementById('approve-form').style.display = 'none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        <i class="fas fa-check mr-2"></i> Setujui
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Reject Form -->
        <div id="reject-form" style="display: none;" class="mt-6 p-4 bg-red-50 rounded-lg">
            <h4 class="text-lg font-semibold mb-4">Tolak Surat</h4>
            <form action="{{ route('approval.reject', $surat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="reject-catatan" class="block text-gray-700 text-sm font-bold mb-2">
                        Catatan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="reject-catatan" name="catatan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="reject-file" class="block text-gray-700 text-sm font-bold mb-2">
                        File Catatan (Opsional)
                    </label>
                    <input type="file" id="reject-file" name="file_catatan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <p class="text-gray-500 text-xs mt-1">Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Maks. 2MB)</p>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="button" onclick="document.getElementById('reject-form').style.display = 'none'" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        <i class="fas fa-times mr-2"></i> Tolak
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection