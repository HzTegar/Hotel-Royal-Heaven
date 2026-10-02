@extends('layouts.admin')

@section('page_title', 'Edit Tipe Kamar')
@section('page_subtitle', 'Ubah informasi tipe kamar')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Edit Tipe Kamar</h2>
        <a href="{{ route('admin.tipe-kamar.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tipe-kamar.update', $tipeKamar) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_tipe" class="block text-sm font-medium text-gray-700 mb-2">Nama Tipe Kamar</label>
            <input type="text" name="nama_tipe" id="nama_tipe" value="{{ old('nama_tipe', $tipeKamar->nama_tipe) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('nama_tipe') border-red-500 @enderror"
                   placeholder="Masukkan nama tipe kamar" required>
            @error('nama_tipe')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="harga_dasar" class="block text-sm font-medium text-gray-700 mb-2">Harga Dasar (Rp)</label>
            <input type="number" name="harga_dasar" id="harga_dasar" value="{{ old('harga_dasar', $tipeKamar->harga_dasar) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('harga_dasar') border-red-500 @enderror"
                   placeholder="Masukkan harga dasar" min="0" required>
            @error('harga_dasar')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="max_tamu" class="block text-sm font-medium text-gray-700 mb-2">Maksimal Tamu</label>
            <input type="number" name="max_tamu" id="max_tamu" value="{{ old('max_tamu', $tipeKamar->max_tamu) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('max_tamu') border-red-500 @enderror"
                   placeholder="Masukkan maksimal tamu" min="1" required>
            @error('max_tamu')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.tipe-kamar.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                Batal
            </a>
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
