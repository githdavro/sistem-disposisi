@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('content')
<div class="w-full space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Role & Permission</h1>
            <p class="text-gray-500 mt-1">Kelola tingkat akses dan izin fitur aplikasi.</p>
        </div>
        <a href="{{ route('roles.create') }}" class="inline-flex items-center justify-center px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl shadow-lg transition-all transform active:scale-95">
            <span class="material-symbols-outlined mr-2">add_moderator</span>
            Tambah Role Baru
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-6 py-5 text-left text-xs font-black text-gray-400 uppercase">Nama Role</th>
                    <th class="px-6 py-5 text-left text-xs font-black text-gray-400 uppercase">Permissions</th>
                    <th class="px-6 py-5 text-center text-xs font-black text-gray-400 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($roles as $role)
                <tr class="hover:bg-indigo-50/30 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $role->name }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($role->permissions as $v)
                                <span class="px-2 py-0.5 bg-gray-100 text-[10px] rounded-lg text-gray-600 font-medium border border-gray-200">{{ $v->name }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('roles.edit', $role->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            @if($role->name !== 'Admin')
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-xl" onclick="return confirm('Hapus role ini?')">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection