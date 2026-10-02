@extends('layouts.admin')

@section('page_title', 'Edit Kamar')
@section('page_subtitle', 'Mengedit data kamar nomor ' . $kamar->nomor_kamar)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('admin.kamar.update', $kamar) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="nomor_kamar" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Kamar
                    </label>
                    <input 
                        type="text" 
                        id="nomor_kamar" 
                        name="nomor_kamar" 
                        placeholder="Cth: 101, 102, A-01" 
                        required
                        value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('nomor_kamar') border-red-500 @enderror"
                    >
                    @error('nomor_kamar')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="id_tipe" class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Kamar
                    </label>
                    <select 
                        id="id_tipe" 
                        name="id_tipe" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('id_tipe') border-red-500 @enderror"
                    >
                        <option value="">-- Pilih Tipe Kamar --</option>
                        @foreach($tipe as $t)
                            <option value="{{ $t->id_tipe }}" @selected(old('id_tipe', $kamar->id_tipe) == $t->id_tipe)>
                                {{ $t->nama_tipe }} (Rp {{ number_format($t->harga_dasar, 0, ',', '.') }}/malam)
                            </option>
                        @endforeach
                    </select>
                    @error('id_tipe')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_ketersediaan" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Ketersediaan
                    </label>
                    <select 
                        id="status_ketersediaan" 
                        name="status_ketersediaan" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('status_ketersediaan') border-red-500 @enderror"
                    >
                        <option value="">-- Pilih Status --</option>
                        <option value="available" @selected(old('status_ketersediaan', $kamar->status_ketersediaan) == 'available')>Tersedia</option>
                        <option value="booked" @selected(old('status_ketersediaan', $kamar->status_ketersediaan) == 'booked')>Dipesan</option>
                        <option value="maintenance" @selected(old('status_ketersediaan', $kamar->status_ketersediaan) == 'maintenance')>Pemeliharaan</option>
                    </select>
                    @error('status_ketersediaan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Kamar
                    </label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        placeholder="Deskripsikan fitur dan fasilitas kamar"
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                    >{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Kamar Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Foto Utama Kamar
                    </label>
                    <div class="space-y-3">
                        <!-- Current Image Display -->
                        @if($kamar->foto_kamar)
                            <div class="mb-3" id="current_foto_kamar_container">
                                <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                <div class="relative inline-block">
                                    <img src="{{ asset('storage/' . $kamar->foto_kamar) }}" alt="Foto Kamar" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-200 shadow-md">
                                    <button type="button" onclick="removeCurrentFotoKamar()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                        ×
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Upload Area -->
                        <div class="relative">
                            <input
                                type="file"
                                id="foto_kamar"
                                name="foto_kamar"
                                accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            >
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-yellow-400 transition-colors duration-200 bg-gray-50 hover:bg-yellow-50">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600 mb-1">
                                        <span class="font-medium text-yellow-600">Klik untuk upload</span> atau drag & drop
                                    </p>
                                    <p class="text-xs text-gray-500">JPG, PNG, GIF (maksimal 2MB) - Kosongkan jika tidak ingin mengubah</p>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Area -->
                        <div id="foto_kamar_preview" class="hidden">
                            <div class="relative inline-block">
                                <img id="foto_kamar_img" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg border-2 border-yellow-200 shadow-md">
                                <button type="button" onclick="removeFotoKamar()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                    ×
                                </button>
                            </div>
                        </div>

                        @error('foto_kamar')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Foto Detail Section -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Foto Detail Kamar
                    </label>
                    <div class="space-y-3">
                        <!-- Current Images Display -->
                        @if($kamar->foto_detail)
                            <div class="mb-3" id="current_foto_kamar_container">
                                <p class="text-sm text-gray-600 mb-2">Foto detail saat ini:</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3">
                                    @foreach(json_decode($kamar->foto_detail, true) as $index => $detailPhoto)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $detailPhoto) }}" alt="Foto Detail" class="w-full h-24 object-cover rounded-lg border-2 border-gray-200 shadow-md">
                                            <button type="button" onclick="removeCurrentDetailPhoto({{ $index }})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                                ×
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Upload Area -->
                        <div class="relative">
                            <input
                                type="file"
                                id="foto_detail"
                                name="foto_detail[]"
                                accept="image/*"
                                multiple
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                            >
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-yellow-400 transition-colors duration-200 bg-gray-50 hover:bg-yellow-50">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <p class="text-sm text-gray-600 mb-1">
                                        <span class="font-medium text-yellow-600">Klik untuk upload</span> atau drag & drop
                                    </p>
                                    <p class="text-xs text-gray-500">Beberapa file JPG, PNG, GIF (maksimal 2MB per file) - Kosongkan jika tidak ingin mengubah</p>
                                </div>
                            </div>
                        </div>

                        <!-- Preview Area -->
                        <div id="foto_detail_preview" class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <!-- Previews will be added here dynamically -->
                        </div>

                        @error('foto_detail.*')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3 pt-6">
                    <button 
                        type="submit" 
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200"
                    >
                        Simpan Perubahan
                    </button>
                    <a
                        href="{{ route('admin.kamar.index') }}"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 text-center"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
