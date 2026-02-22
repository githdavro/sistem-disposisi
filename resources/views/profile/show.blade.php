@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="w-full mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Profil Pengguna</h1>
            <p class="text-gray-500 mt-1">Kelola informasi akun dan tinjau aktivitas Anda.</p>
        </div>
        
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition all duration-200">
            <span class="material-symbols-outlined text-sm mr-2">arrow_back</span>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center transition-all hover:shadow-md">
                <div class="relative inline-block">
                    <div class="w-28 h-28 bg-gradient-to-tr from-indigo-600 to-purple-500 rounded-full border-4 border-white shadow-xl flex items-center justify-center text-white text-3xl font-bold mx-auto">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <span class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></span>
                </div>
                
                <h2 class="mt-6 text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                <p class="text-gray-500 text-sm mb-4">{{ auth()->user()->email }}</p>
                
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase
                    {{ auth()->user()->getRoleNames()->first() == 'Admin' ? 'bg-purple-100 text-purple-700' : 
                       (auth()->user()->getRoleNames()->first() == 'Direktur' ? 'bg-blue-100 text-blue-700' : 
                       (auth()->user()->getRoleNames()->first() == 'Pengadaan' ? 'bg-amber-100 text-amber-700' : 
                       'bg-emerald-100 text-emerald-700')) }}">
                    {{ auth()->user()->getRoleNames()->first() }}
                </div>

                <div class="mt-8 pt-6 border-t border-gray-50">
                    <a href="{{ route('profile.edit') }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gray-900 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all">
                        <span class="material-symbols-outlined text-sm mr-2">edit</span>
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center group">
                    <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 mr-4 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined">outbox</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Surat Terkirim</p>
                        <p class="text-3xl font-black text-gray-800">{{ auth()->user()->suratTerkirim->count() }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center group">
                    <div class="w-14 h-14 flex items-center justify-center rounded-2xl bg-green-50 text-green-600 mr-4 group-hover:bg-green-400 group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined">task_alt</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Disetujui</p>
                        <p class="text-3xl font-black text-gray-800">{{ auth()->user()->approval->where('status', 'Disetujui')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800">Informasi Detail</h3>
                </div>
                <div class="p-8">
                    <dl class="divide-y divide-gray-100">
                        <div class="py-4 flex flex-col sm:flex-row sm:justify-between">
                            <dt class="text-sm font-medium text-gray-500">Unit Kerja</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 sm:mt-0">{{ auth()->user()->unit->nama_unit ?? 'Tidak Ada Unit' }}</dd>
                        </div>
                        <div class="py-4 flex flex-col sm:flex-row sm:justify-between">
                            <dt class="text-sm font-medium text-gray-500">ID Pengguna</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900 sm:mt-0">#{{ str_pad(auth()->user()->id, 5, '0', STR_PAD_LEFT) }}</dd>
                        </div>
                        <div class="py-4 flex flex-col sm:flex-row sm:justify-between">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Bergabung</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 sm:mt-0">{{ auth()->user()->created_at->translatedFormat('d F Y') }}</dd>
                        </div>
                        <div class="py-4 flex flex-col sm:flex-row sm:justify-between">
                            <dt class="text-sm font-medium text-gray-500">Status Akun</dt>
                            <dd class="mt-1 text-sm sm:mt-0">
                                <span class="text-emerald-600 flex items-center font-semibold">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span> Aktif
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection