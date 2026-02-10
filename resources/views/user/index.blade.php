@extends('layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pengguna</h1>
        <p class="text-gray-600">Kelola semua pengguna dalam sistem</p>
    </div>
    @if(Auth::user()->hasPermissionTo('user-create'))
        <a href="{{ route('user.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> Tambah Pengguna
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
                    Nama
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Email
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Unit
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Role
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $index => $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $user->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $user->unit->nama_unit ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->getRoleNames()->first() == 'Admin' ? 'bg-purple-100 text-purple-800' : 
                               ($user->getRoleNames()->first() == 'Direktur' ? 'bg-indigo-100 text-indigo-800' : 
                               ($user->getRoleNames()->first() == 'Pengadaan' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-green-100 text-green-800')) }}">
                            {{ $user->getRoleNames()->first() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('user.show', $user->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                        @if(Auth::user()->hasPermissionTo('user-edit'))
                            <a href="{{ route('user.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
                        @if(Auth::user()->hasPermissionTo('user-delete') && $user->id != Auth::id())
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
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
        {{ $users->links() }}
    </div>
</div>
@endsection