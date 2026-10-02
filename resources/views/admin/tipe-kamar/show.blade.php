@extends('layouts.admin')

@section('page_title', 'Detail Tipe Kamar')
@section('page_subtitle', 'Informasi lengkap tipe kamar')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Detail Tipe Kamar</h2>
        <div class="flex space-x-3">
            <a href="{{ route('admin.tipe-kamar.edit', $tipeKamar) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                Edit
            </a>
            <a href="{{ route('admin.tipe-kamar.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>
    </div>

    <!-- Tipe Kamar Info -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Tipe Kamar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Tipe</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $tipeKamar->nama_tipe }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Harga Dasar</label>
                    <p class="mt-1 text-lg font-semibold text-green-600">Rp {{ number_format($tipeKamar->harga_dasar, 0, ',', '.') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Maksimal Tamu</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $tipeKamar->max_tamu }} orang</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Kamars -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Kamar Terkait ({{ $tipeKamar->kamars->count() }} kamar)</h3>

            @if($tipeKamar->kamars->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Kamar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($tipeKamar->kamars as $kamar)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $kamar->nomor_kamar }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @switch($kamar->status_ketersediaan)
                                            @case('available') bg-green-100 text-green-800 @break
                                            @case('booked') bg-yellow-100 text-yellow-800 @break
                                            @case('maintenance') bg-red-100 text-red-800 @break
                                        @endswitch">
                                        {{ ucfirst($kamar->status_ketersediaan) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $kamar->deskripsi }}">
                                    {{ Str::limit($kamar->deskripsi, 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.kamar.show', $kamar) }}" class="text-blue-600 hover:text-blue-900">Lihat Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p class="text-gray-500">Belum ada kamar yang terkait dengan tipe ini.</p>
                    <a href="{{ route('admin.kamar.create') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800">Tambah Kamar Baru</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
