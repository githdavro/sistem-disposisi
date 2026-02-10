@extends('layouts.app')

@section('title', 'Daftar Unit')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Unit</h1>
        <p class="text-gray-600">Kelola semua unit dalam sistem</p>
    </div>
    @if(Auth::user()->hasPermissionTo('unit-create'))
        <a href="{{ route('unit.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Tambah Unit
        </a>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    No.
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nama Unit
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Jumlah User
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Tanggal Dibuat
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($unit as $index => $u)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ ($unit->currentPage() - 1) * $unit->perPage() + $index + 1 }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $u->nama_unit }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $u->user_count }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $u->created_at->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('unit.show', $u->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                        @if(Auth::user()->hasPermissionTo('unit-edit'))
                            <a href="{{ route('unit.edit', $u->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
                        @if(Auth::user()->hasPermissionTo('unit-delete'))
                            <form action="{{ route('unit.destroy', $u->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus unit ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="p-4 border-t">
        {{ $unit->links() }}
    </div>
</div>
@endsection