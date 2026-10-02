@extends('layouts.admin')

@section('page_title', 'Manajemen Tipe Kamar')
@section('page_subtitle', 'Kelola semua tipe kamar di hotel Royal Heaven')

@section('content')
<div class="overflow-x-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Daftar Tipe Kamar</h2>
        <a href="{{ route('admin.tipe-kamar.create') }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
            Tambah Tipe Kamar
        </a>
    </div>

    {{-- Filter and Search --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.tipe-kamar.index') }}">
            <div class="flex gap-4">
                <input type="text" name="search" placeholder="Cari nama tipe kamar..." class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" value="{{ request('search') }}">
                <button type="submit" class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">Cari</button>
                <a href="{{ route('admin.tipe-kamar.index') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">Reset</a>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-yellow-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Harga Dasar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Max Tamu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jumlah Kamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($tipeKamars as $tipe)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $tipe->nama_tipe }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                        Rp {{ number_format($tipe->harga_dasar, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $tipe->max_tamu }} orang
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $tipe->kamars_count }} kamar
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.tipe-kamar.show', $tipe) }}" class="text-blue-600 hover:text-blue-900">Lihat</a>
                            <a href="{{ route('admin.tipe-kamar.edit', $tipe) }}" class="text-green-600 hover:text-green-900">Edit</a>
                            <form action="{{ route('admin.tipe-kamar.destroy', $tipe) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tipe kamar ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <p class="font-semibold">Tidak ada data tipe kamar.</p>
                            <p class="text-sm">Data akan muncul di sini setelah ada tipe kamar yang ditambahkan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $tipeKamars->links() }}
    </div>
</div>
@endsection
