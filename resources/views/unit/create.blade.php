@extends('layouts.app')

@section('title', 'Tambah Unit Baru')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Tambah Unit Baru</h1>
    <p class="text-gray-600">Isi formulir di bawah untuk menambah unit baru</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('unit.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="nama_unit" class="block text-gray-700 text-sm font-bold mb-2">
                Nama Unit <span class="text-red-500">*</span>
            </label>
            <input type="text" id="nama_unit" name="nama_unit" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('nama_unit') }}" required>
            @error('nama_unit')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex items-center justify-between">
            <a href="{{ route('unit.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection