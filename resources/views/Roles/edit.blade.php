@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="w-full max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('roles.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-gray-100 text-gray-400 hover:text-indigo-600 transition-all">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Role: {{ $role->name }}</h1>
            <p class="text-gray-500 mt-1">Perbarui nama role atau sesuaikan kembali hak aksesnya.</p>
        </div>
    </div>

    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        @csrf
        @method('PATCH')
        
        <div class="p-8 md:p-12 space-y-10">
            {{-- Role Name --}}
            <div class="space-y-3">
                <label for="name" class="text-sm font-black text-gray-400 uppercase tracking-widest ml-1">Nama Role</label>
                <input type="text" name="name" id="name" value="{{ $role->name }}"
                    class="w-full px-6 py-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all font-bold text-gray-900 shadow-inner" required>
            </div>

            {{-- Permissions Grid --}}
            <div class="space-y-6">
                <label class="text-sm font-black text-gray-400 uppercase tracking-widest ml-1 block">Modifikasi Hak Akses</label>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($permission as $value)
                        <label class="group relative flex items-center p-4 {{ in_array($value->id, $rolePermissions) ? 'bg-indigo-50/50 border-indigo-200' : 'bg-gray-50 border-transparent' }} border-2 hover:border-indigo-200 rounded-2xl transition-all cursor-pointer">
                            <div class="flex items-center gap-4 z-10">
                                <input type="checkbox" name="permission[]" value="{{ $value->id }}" 
                                    class="w-5 h-5 rounded-lg border-gray-300 text-indigo-600 focus:ring-indigo-500/30 transition-all cursor-pointer"
                                    {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                <span class="text-sm font-bold {{ in_array($value->id, $rolePermissions) ? 'text-indigo-700' : 'text-gray-600' }} group-hover:text-indigo-700 transition-colors">
                                    {{ $value->name }}
                                </span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('roles.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black rounded-2xl shadow-lg shadow-indigo-100 transition-all transform active:scale-95">
                Update Role
            </button>
        </div>
    </form>
</div>
@endsection