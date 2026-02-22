@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')
<div class="w-full space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Pengguna</h1>
            <p class="text-gray-500 mt-1">Total {{ $users->total() }} akun terdaftar dalam sistem disposisi.</p>
        </div>
        
        @if(Auth::user()->hasPermissionTo('user-create'))
            <a href="{{ route('user.create') }}" class="inline-flex items-center justify-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-blue-100 transition-all transform active:scale-95">
                <span class="material-symbols-outlined mr-2 text-lg font-bold">person_add</span>
                Tambah Pengguna Baru
            </a>
        @endif
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-[0.15em]">Pengguna</th>
                        <th class="px-6 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-[0.15em]">Kontak & Unit</th>
                        <th class="px-6 py-5 text-left text-xs font-black text-gray-400 uppercase tracking-[0.15em]">Hak Akses</th>
                        <th class="px-6 py-5 text-center text-xs font-black text-gray-400 uppercase tracking-[0.15em]">Opsi Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        {{-- Nama & Avatar --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-4">
                                <div class="h-11 w-11 rounded-2xl bg-gradient-to-tr from-gray-100 to-gray-200 border-2 border-white shadow-sm flex items-center justify-center text-gray-600 font-black">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 leading-none">{{ $user->name }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono mt-1.5 bg-gray-50 px-1.5 py-0.5 rounded inline-block">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Email & Unit --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-600 font-medium flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base text-gray-400">mail</span> {{ $user->email }}
                                </span>
                                <span class="text-xs font-bold text-blue-600 mt-1 ml-5.5 pl-0.5">
                                    {{ $user->unit->nama_unit ?? 'Internal PT GPM' }}
                                </span>
                            </div>
                        </td>

                        {{-- Role Badge --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $role = $user->getRoleNames()->first();
                                $colorClasses = match($role) {
                                    'Admin' => 'bg-purple-50 text-purple-700 border-purple-100',
                                    'Direktur' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                    'Pengadaan' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    default => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider border {{ $colorClasses }}">
                                {{ $role }}
                            </span>
                        </td>

                        {{-- Actions (Selalu Muncul) --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex justify-center items-center gap-1">
                                <a href="{{ route('user.show', $user->id) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all" title="Lihat Detail">
                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                </a>
                                
                                @if(Auth::user()->hasPermissionTo('user-edit'))
                                    <a href="{{ route('user.edit', $user->id) }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Edit Pengguna">
                                        <span class="material-symbols-outlined text-xl">edit_square</span>
                                    </a>
                                @endif

                                @if(Auth::user()->hasPermissionTo('user-delete') && $user->id != Auth::id())
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" 
                                                onclick="return confirm('Hapus pengguna ini?')" title="Hapus">
                                            <span class="material-symbols-outlined text-xl">delete</span>
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

        {{-- Pagination --}}
        <div class="px-8 py-5 bg-gray-50/50 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection