@extends('layouts.app')

@section('page_title', 'Detail Kamar - ' . $kamar->nomor_kamar)

@section('content')
{{-- Pastikan Anda tidak memiliki tag <body> atau </head> yang terbuka atau tertutup di sini
karena sudah ada di 'layouts.app' --}}

{{-- Header dipisah ke komponen --}}
@include('components.Navbar')

{{-- Hero Section for Room Detail --}}
<x-hero-section
    title="{{ $kamar->nomor_kamar }} - {{ $kamar->tipe->nama_tipe }}"
    subtitle="Luxury Accommodation"
    description="{{ $kamar->deskripsi ?: 'Nikmati kenyamanan menginap di kamar yang dirancang untuk memberikan pengalaman terbaik. Kamar ini dilengkapi dengan fasilitas modern dan pelayanan prima untuk memastikan istirahat Anda maksimal.' }}"
    :image="'user/GambarHeroSection.jpg'"
    ctaText="Pesan Sekarang"
    ctaLink="#booking-section"
    splitPercent="50"
    angle="105"
/>

<div class="min-h-screen bg-gray-50">
    <!-- Header with Back Button -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ auth()->check() && auth()->user()->role === 'member' ? route('member.kamar.index') : route('daftarkamar') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Daftar Kamar
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @if($kamar->status_ketersediaan === 'available')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Tidak Tersedia
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Room Image Gallery -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Main Image -->
                    @if($kamar->foto_kamar)
                        <div class="aspect-w-16 aspect-h-9">
                            <img id="mainImage" src="{{ asset('storage/' . $kamar->foto_kamar) }}" alt="{{ $kamar->nomor_kamar }} - Main Image" class="w-full h-96 lg:h-[500px] object-cover cursor-pointer" onclick="document.getElementById('mainImage').src = this.src">
                        </div>
                    @endif

                    <!-- Detail Images Thumbnails -->
                    @php
                        $detailPhotos = json_decode($kamar->foto_detail, true);
                    @endphp
                    @if($detailPhotos && is_array($detailPhotos) && count($detailPhotos) > 0)
                        <div class="p-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Foto Detail Kamar</h3>
                            <div class="grid grid-cols-3 gap-4">
                                @foreach($detailPhotos as $index => $detailImage)
                                    <div class="aspect-w-1 aspect-h-1">
                                        <img id="detailImage{{ $index }}" src="{{ asset('storage/' . $detailImage) }}" alt="{{ $kamar->nomor_kamar }} - Detail {{ $index + 1 }}" class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity" onclick="document.getElementById('mainImage').src = this.src">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Room Information -->
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $kamar->nomor_kamar }}</h1>
                        <p class="text-xl text-gray-600">{{ $kamar->tipe->nama_tipe }}</p>
                    </div>

                    <!-- Room Specifications -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                        <div class="text-center">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="text-sm text-gray-600">Kapasitas</div>
                            <div class="font-semibold">{{ $kamar->tipe->kapasitas }} Orang</div>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-lg mx-auto mb-2">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="text-sm text-gray-600">Luas</div>
                            <div class="font-semibold">{{ $kamar->tipe->luas }} m²</div>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mx-auto mb-2">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                            </div>
                            <div class="text-sm text-gray-600">Tempat Tidur</div>
                            <div class="font-semibold">{{ $kamar->tipe->tempat_tidur }}</div>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center w-12 h-12 bg-orange-100 rounded-lg mx-auto mb-2">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div class="text-sm text-gray-600">Kamar Mandi</div>
                            <div class="font-semibold">{{ $kamar->tipe->kamar_mandi }}</div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="border-t pt-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Tentang Kamar Ini</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $kamar->deskripsi ?: 'Nikmati kenyamanan menginap di kamar yang dirancang untuk memberikan pengalaman terbaik. Kamar ini dilengkapi dengan fasilitas modern dan pelayanan prima untuk memastikan istirahat Anda maksimal.' }}
                        </p>
                    </div>
                </div>

                <!-- Facilities -->
                @if($kamar->tipe->fasilitas)
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Fasilitas & Layanan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(explode(',', $kamar->tipe->fasilitas) as $fasilitas)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700 font-medium">{{ trim($fasilitas) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Reviews Section -->
                <div class="bg-white rounded-xl shadow-sm p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Ulasan & Rating</h3>
                            @if($totalReviews > 0)
                                <div class="flex items-center mt-2">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-lg font-semibold text-gray-900">{{ number_format($averageRating, 1) }}</span>
                                    <span class="ml-1 text-gray-600">({{ $totalReviews }} ulasan)</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($totalReviews > 0)
                        <div class="space-y-6">
                            @foreach($reviews as $review)
                                <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="ml-2 text-sm font-medium text-gray-900">{{ $review->user->nama_lengkap ?? 'Anonymous' }}</span>
                                            </div>
                                            @if($review->komentar)
                                                <p class="text-gray-700 leading-relaxed">{{ $review->komentar }}</p>
                                            @endif
                                            <p class="text-sm text-gray-500 mt-2">{{ $review->created_at ? \Carbon\Carbon::parse($review->created_at)->format('d M Y') : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($reviews->hasPages())
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-gray-500 text-lg mb-2">Belum ada ulasan</p>
                            <p class="text-gray-400 text-sm">Jadilah yang pertama memberikan ulasan untuk kamar ini</p>
                        </div>
                    @endif

                    <!-- Review Form -->
                    @if($canReview)
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Tulis Ulasan Anda</h4>

                            @if(session('success'))
                                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                                    <ul class="list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('member.reviews.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="id_kamar" value="{{ $kamar->id_kamar }}">

                                <!-- Rating Input -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                    <div class="flex items-center space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" class="sr-only peer" required>
                                            <label for="rating-{{ $i }}" class="cursor-pointer text-gray-300 hover:text-yellow-400 peer-checked:text-yellow-400">
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </label>
                                        @endfor
                                    </div>
                                </div>

                                <!-- Comment Input -->
                                <div>
                                    <label for="komentar" class="block text-sm font-medium text-gray-700 mb-2">Komentar (Opsional)</label>
                                    <textarea
                                        id="komentar"
                                        name="komentar"
                                        rows="4"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 resize-none"
                                        placeholder="Bagikan pengalaman Anda menginap di kamar ini..."
                                        maxlength="1000"
                                    ></textarea>
                                    <p class="text-sm text-gray-500 mt-1">Maksimal 1000 karakter</p>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Kirim Ulasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    @elseif(auth()->check() && auth()->user()->role === 'member')
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <div class="text-center py-4">
                                <p class="text-gray-500 text-sm">Untuk memberikan ulasan, Anda harus sudah menyelesaikan pemesanan kamar ini terlebih dahulu.</p>
                            </div>
                        </div>
                    @else
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <div class="text-center py-4">
                                <p class="text-gray-500 text-sm">
                                    <a href="{{ route('login') }}" class="text-yellow-600 hover:text-yellow-700 font-medium">Masuk</a>
                                    untuk memberikan ulasan
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-8">
                    <div class="text-center mb-6">
                        <div class="text-3xl font-bold text-gray-900 mb-1">
                            Rp {{ number_format($kamar->tipe->harga_dasar, 0, ',', '.') }}
                        </div>
                        <div class="text-gray-600">per malam</div>
                    </div>

                    @auth
                        @if(auth()->user()->role === 'member')
                            <button
                                id="wishlist-btn"
                                data-in-wishlist="{{ $inWishlist ? 'true' : 'false' }}"
                                data-kamar-id="{{ $kamar->id_kamar }}"
                                class="w-full {{ $inWishlist ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-500 hover:bg-gray-600' }} text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span id="wishlist-text">{{ $inWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}</span>
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Masuk untuk Tambah Wishlist
                        </a>
                    @endauth

                    @if($kamar->status_ketersediaan === 'available')
                        @auth
                            @if(auth()->user()->role === 'member')
                                <button
                                   onclick="openBookingModal({{ $kamar->id_kamar }})"
                                   class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center mb-4">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m0 0l-2-2m2 2l2-2m6-6v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2h8a2 2 0 012 2z"></path>
                                    </svg>
                                    Pesan Sekarang
                                </button>
                        @else
                            <button onclick="openBookingModal({{ $kamar->id_kamar }})" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m0 0l-2-2m2 2l2-2m6-6v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2h8a2 2 0 012 2z"></path>
                                </svg>
                                Pesan Sekarang
                            </button>
                        @endif
                        @else
                            <a href="{{ route('login') }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m0 0l-2-2m2 2l2-2m6-6v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2h8a2 2 0 012 2z"></path>
                                </svg>
                                Pesan Sekarang
                            </a>
                        @endauth
                    @else
                        <button disabled class="w-full bg-gray-300 text-gray-500 font-semibold py-4 px-6 rounded-lg cursor-not-allowed flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Kamar Tidak Tersedia
                        </button>
                    @endif

                    <div class="border-t pt-6 mt-6">
                        <h4 class="font-semibold text-gray-900 mb-3">Informasi Penting</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Check-in: 14:00 WIB
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Check-out: 12:00 WIB
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Pembatalan gratis hingga 24 jam
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Booking Modal -->
    <div id="bookingModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 pt-20 pb-20">
            <!-- Background overlay with blur -->
            <div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-all duration-300" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div id="modalPanel" class="relative bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0 max-w-4xl w-full max-h-[90vh] overflow-hidden">
                <!-- Header with gradient -->
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-8 py-6">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-full">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m0 0l-2-2m2 2l2-2m6-6v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2h8a2 2 0 012 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white" id="modal-title">
                                    Pesan Kamar Anda
                                </h3>
                                <p class="text-yellow-100 text-sm mt-1">
                                    {{ $kamar->nomor_kamar }} - {{ $kamar->tipe->nama_tipe }}
                                </p>
                            </div>
                        </div>
                        <button id="closeModalBtn" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-2 rounded-full transition-all duration-200 hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-8 py-6 max-h-[calc(90vh-200px)] overflow-y-auto">
                    @auth
                        @if(auth()->user()->role === 'member')
                            <livewire:booking-form :selectedKamarId="$kamar->id_kamar" />
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg mb-2">Akses Terbatas</p>
                                <p class="text-gray-400 text-sm">Hanya member yang dapat melakukan pemesanan.</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <p class="text-gray-500 text-lg mb-2">Login Diperlukan</p>
                            <p class="text-gray-400 text-sm mb-4">Silakan login untuk melakukan pemesanan kamar.</p>
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Login Sekarang
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Aman & Terpercaya
                            </p>
                        </div>
                        <div class="text-xs text-gray-500">
                            Butuh bantuan? <a href="#" class="text-yellow-600 hover:text-yellow-700 font-medium">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>

<script>
    function openBookingModal(kamarId) {
        const modal = document.getElementById('bookingModal');
        const modalPanel = document.getElementById('modalPanel');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Trigger animation
        setTimeout(() => {
            modalPanel.classList.remove('scale-95', 'opacity-0');
            modalPanel.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Update Livewire component with selected room
        if (window.livewire) {
            window.livewire.find('booking-form').call('setSelectedRoom', kamarId);
        }
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        const modalPanel = document.getElementById('modalPanel');

        // Trigger close animation
        modalPanel.classList.remove('scale-100', 'opacity-100');
        modalPanel.classList.add('scale-95', 'opacity-0');

        // Hide modal after animation
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Event listeners
    document.getElementById('closeModalBtn').addEventListener('click', closeBookingModal);
    document.getElementById('modalBackdrop').addEventListener('click', closeBookingModal);

    // Listen for booking success event
    window.addEventListener('booking-success', function() {
        closeBookingModal();
    });

    // Star rating functionality
    document.addEventListener('DOMContentLoaded', function() {
        const ratingInputs = document.querySelectorAll('input[name="rating"]');
        const starLabels = document.querySelectorAll('label[for^="rating-"]');

        function updateStars(selectedValue) {
            starLabels.forEach((label, index) => {
                const starValue = index + 1;
                const starSvg = label.querySelector('svg');

                if (starValue <= selectedValue) {
                    // Selected stars - yellow
                    starSvg.classList.remove('text-gray-300');
                    starSvg.classList.add('text-yellow-400');
                } else {
                    // Unselected stars - gray
                    starSvg.classList.remove('text-yellow-400');
                    starSvg.classList.add('text-gray-300');
                }
            });
        }

        // Handle radio button changes
        ratingInputs.forEach(input => {
            input.addEventListener('change', function() {
                updateStars(parseInt(this.value));
            });
        });

        // Handle label clicks for better UX
        starLabels.forEach((label, index) => {
            label.addEventListener('click', function() {
                const value = index + 1;
                const radioInput = document.getElementById(`rating-${value}`);
                radioInput.checked = true;
                updateStars(value);
            });
        });

        // Initialize with no stars selected
        updateStars(0);
    });

    // Wishlist functionality
    document.addEventListener('DOMContentLoaded', function() {
        const wishlistBtn = document.getElementById('wishlist-btn');
        if (wishlistBtn) {
            wishlistBtn.addEventListener('click', function(event) {
                const kamarId = event.target.getAttribute('data-kamar-id');
                const isInWishlist = event.target.getAttribute('data-in-wishlist') === 'true';
                const wishlistText = document.getElementById('wishlist-text');

                // Disable button during request
                this.disabled = true;
                this.classList.add('opacity-50', 'cursor-not-allowed');

                if (isInWishlist) {
                    // Remove from wishlist
                    fetch(`/member/wishlist/${kamarId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.setAttribute('data-in-wishlist', 'false');
                            this.classList.remove('bg-red-500', 'hover:bg-red-600');
                            this.classList.add('bg-gray-500', 'hover:bg-gray-600');
                            wishlistText.textContent = 'Tambah ke Wishlist';
                            showNotification('Kamar berhasil dihapus dari wishlist', 'success');
                        } else {
                            showNotification(data.message || 'Gagal menghapus dari wishlist', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Terjadi kesalahan saat menghapus dari wishlist', 'error');
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                } else {
                    // Add to wishlist
                    const formData = new FormData();
                    formData.append('id_kamar', kamarId);

                    fetch('/member/wishlist', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.setAttribute('data-in-wishlist', 'true');
                            this.classList.remove('bg-gray-500', 'hover:bg-gray-600');
                            this.classList.add('bg-red-500', 'hover:bg-red-600');
                            wishlistText.textContent = 'Hapus dari Wishlist';
                            showNotification('Kamar berhasil ditambahkan ke wishlist', 'success');
                        } else {
                            showNotification(data.message || 'Gagal menambahkan ke wishlist', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Terjadi kesalahan saat menambahkan ke wishlist', 'error');
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                }
            });
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg font-medium shadow-lg transform transition-all duration-300 translate-x-full`;

            if (type === 'success') {
                notification.classList.add('bg-green-500', 'text-white');
            } else {
                notification.classList.add('bg-red-500', 'text-white');
            }

            notification.textContent = message;
            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    });
</script>

@endsection
