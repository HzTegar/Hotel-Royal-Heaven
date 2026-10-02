@extends('layouts.admin')

@section('page_title', 'Tambah Tipe Kamar')
@section('page_subtitle', 'Tambahkan tipe kamar baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Tambah Tipe Kamar</h2>
        <a href="{{ route('admin.tipe-kamar.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.tipe-kamar.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nama_tipe" class="block text-sm font-medium text-gray-700">Nama Tipe</label>
            <input type="text" name="nama_tipe" id="nama_tipe" value="{{ old('nama_tipe') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500" required>
            @error('nama_tipe')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="harga_dasar" class="block text-sm font-medium text-gray-700">Harga Dasar (Rp)</label>
            <input type="number" name="harga_dasar" id="harga_dasar" value="{{ old('harga_dasar') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500" min="0" required>
            @error('harga_dasar')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="max_tamu" class="block text-sm font-medium text-gray-700">Maksimal Tamu</label>
            <input type="number" name="max_tamu" id="max_tamu" value="{{ old('max_tamu') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500" min="1" required>
            @error('max_tamu')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.tipe-kamar.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                Batal
            </a>
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
