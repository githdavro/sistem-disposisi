@extends('layouts.app')

@section('title', 'Buat Surat Baru')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Buat Surat Baru</h1>
    <p class="text-gray-600">Isi formulir di bawah untuk membuat surat baru</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        
        <div class="mb-4">
            <label for="unit_tujuan_id" class="block text-gray-700 text-sm font-bold mb-2">
                Unit Tujuan <span class="text-red-500">*</span>
            </label>
            <select id="unit_tujuan_id" name="unit_tujuan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Pilih Unit Tujuan</option>
                @foreach($unit as $u)
                    <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                @endforeach
            </select>
            @error('unit_tujuan_id')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="file" class="block text-gray-700 text-sm font-bold mb-2">
                File Surat <span class="text-red-500">*</span>
            </label>
            <input type="file" id="file" name="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            <p class="text-gray-500 text-xs mt-1">Format: PDF, DOC, DOCX (Maks. 2MB)</p>
            @error('file')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="catatan" class="block text-gray-700 text-sm font-bold mb-2">
                Catatan
            </label>
            <textarea id="catatan" name="catatan" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('catatan') }}</textarea>
            @error('catatan')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="sifat" class="block text-gray-700 text-sm font-bold mb-2">
                Sifat Surat <span class="text-red-500">*</span>
            </label>
            <select id="sifat" name="sifat" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Pilih Sifat Surat</option>
                <option value="Rahasia" {{ old('sifat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                <option value="Penting" {{ old('sifat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                <option value="Disegerakan" {{ old('sifat') == 'Disegerakan' ? 'selected' : '' }}>Disegerakan</option>
            </select>
            @error('sifat')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="nominal" class="block text-gray-700 text-sm font-bold mb-2">
                Nominal (Rp) <span class="text-red-500">*</span>
            </label>
            <input type="number" id="nominal" name="nominal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" step="0.01" min="0" value="{{ old('nominal') }}" required>
            <p class="text-gray-500 text-xs mt-1">Catatan: Surat dengan nominal > 1.000.000 akan memerlukan approval dari Direktur</p>
            @error('nominal')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex items-center justify-between">
            <a href="{{ route('surat.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection