@extends('layouts.app')

@section('title', 'Daftar Surat')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Surat</h1>
        <p class="text-gray-600">Kelola semua surat dalam sistem</p>
    </div>
    @if(Auth::user()->hasPermissionTo('surat-create'))
        <a href="{{ route('surat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Buat Surat Baru
        </a>
    @endif
</div>

<div class="bg-white rounded-lg shadow">
    <div class="p-4 border-b">
        <!-- 使用表单来处理过滤 -->
        <form method="GET" action="{{ route('surat.index') }}" class="mb-4">
            <div class="flex flex-wrap gap-2">
                <input type="hidden" name="filter" value="status">
                <button type="submit" name="status" value="" 
                        class="px-3 py-1 rounded {{ !request()->has('status') || request('status') == '' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Semua
                </button>
                <button type="submit" name="status" value="Menunggu" 
                        class="px-3 py-1 rounded {{ request('status') == 'Menunggu' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Menunggu
                </button>
                <button type="submit" name="status" value="Diproses" 
                        class="px-3 py-1 rounded {{ request('status') == 'Diproses' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Diproses
                </button>
                <button type="submit" name="status" value="Disetujui" 
                        class="px-3 py-1 rounded {{ request('status') == 'Disetujui' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Disetujui
                </button>
                <button type="submit" name="status" value="Ditolak" 
                        class="px-3 py-1 rounded {{ request('status') == 'Ditolak' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Ditolak
                </button>
                <button type="submit" name="status" value="Selesai" 
                        class="px-3 py-1 rounded {{ request('status') == 'Selesai' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Selesai
                </button>
            </div>
        </form>
        
        <!-- 显示当前过滤状态 -->
        @if(request()->has('status') && request('status') != '')
            <div class="text-sm text-gray-600">
                Menampilkan surat dengan status: <span class="font-semibold">{{ request('status') }}</span>
                <a href="{{ route('surat.index') }}" class="ml-2 text-blue-600 hover:text-blue-800">
                    <i class="fas fa-times"></i> Hapus filter
                </a>
            </div>
        @endif
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        No.
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pengirim
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tujuan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nominal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Sifat
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($surat as $index => $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ ($surat->currentPage() - 1) * $surat->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $item->pengirim->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $item->unitTujuan->nama_unit ?? 'Pengadaan' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            Rp. {{ number_format($item->nominal, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $item->sifat == 'Rahasia' ? 'bg-red-100 text-red-800' : 
                                   ($item->sifat == 'Penting' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-blue-100 text-blue-800') }}">
                                {{ $item->sifat }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $item->status == 'Menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($item->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 
                                   ($item->status == 'Disetujui' ? 'bg-green-100 text-green-800' : 
                                   ($item->status == 'Ditolak' ? 'bg-red-100 text-red-800' : 
                                   'bg-gray-100 text-gray-800'))) }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('surat.show', $item->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            @if(Auth::user()->hasPermissionTo('surat-edit') && $item->pengirim_id == Auth::id())
                                <a href="{{ route('surat.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif
                            @if(Auth::user()->hasPermissionTo('surat-delete') && $item->pengirim_id == Auth::id())
                                <form action="{{ route('surat.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            @if(request()->has('status') && request('status') != '')
                                Tidak ada surat dengan status "{{ request('status') }}".
                                <a href="{{ route('surat.index') }}" class="text-blue-600 hover:text-blue-800">
                                    Lihat semua surat
                                </a>
                            @else
                                Tidak ada data surat.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t">
        {{ $surat->appends(request()->query())->links() }}
    </div>
</div>
@endsection