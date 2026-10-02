@extends('layouts.admin')

@section('title', 'Detail Review')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Detail Review</h1>
            <a href="{{ route('admin.reviews.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Kembali
            </a>
        </div>

        <!-- Review Detail -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <!-- User Info -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi User</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $review->user->nama_lengkap }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $review->user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Room Info -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Kamar</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Kamar</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $review->kamar->nomor_kamar }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipe Kamar</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $review->kamar->tipe->nama_tipe ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Content -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Konten Review</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <!-- Rating -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-gray-300 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-3 text-lg font-semibold text-gray-900">{{ $review->rating }}/5</span>
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                            <div class="bg-white rounded-md p-3 border">
                                @if($review->komentar)
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $review->komentar }}</p>
                                @else
                                    <p class="text-gray-500 italic">Tidak ada komentar</p>
                                @endif
                            </div>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Review</label>
                            <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($review->created_at)->format('l, d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.reviews.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Kembali ke Daftar
                    </a>
                    <form action="{{ route('admin.reviews.destroy', $review->id_review) }}"
                          method="POST" class="inline"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus review ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Hapus Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
