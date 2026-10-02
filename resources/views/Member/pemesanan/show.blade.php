@extends(auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.app')

@section('page_title', 'Detail Pemesanan')

@section('content')
{{-- Hero Section --}}
<x-hero-sectionDetailPemesanan
    :description="'Pantau status pemesanan, detail kamar, dan informasi pembayaran Anda dengan mudah. Kami siap memberikan pengalaman menginap yang tak terlupakan.'"
    :ctaText="'Lihat Detail Lengkap'"
    :ctaLink="'#booking-details'"
/>
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8 pt-24">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Pemesanan</h1>
                        <p class="text-gray-600">Kode: <span class="font-mono font-semibold text-lg">{{ $pemesanan->kode_pemesanan }}</span></p>
                    </div>

                    @php
                        $statusClass = 'bg-gray-100 text-gray-800';
                        $statusIcon = '⏳';
                        if (strpos(strtolower($pemesanan->status_pemesanan), 'pending') !== false) {
                            $statusClass = 'bg-yellow-100 text-yellow-800';
                            $statusIcon = '⏳';
                        } elseif (strpos(strtolower($pemesanan->status_pemesanan), 'confirmed') !== false) {
                            $statusClass = 'bg-green-100 text-green-800';
                            $statusIcon = '✅';
                        } elseif (strpos(strtolower($pemesanan->status_pemesanan), 'completed') !== false) {
                            $statusClass = 'bg-blue-100 text-blue-800';
                            $statusIcon = '🏁';
                        } elseif (strpos(strtolower($pemesanan->status_pemesanan), 'cancelled') !== false) {
                            $statusClass = 'bg-red-100 text-red-800';
                            $statusIcon = '❌';
                        }
                    @endphp
                    <div class="flex items-center space-x-3">
                        <span class="px-6 py-3 text-lg font-semibold rounded-full {{ $statusClass }} shadow-sm">
                            <span class="mr-2">{{ $statusIcon }}</span>
                            {{ ucfirst($pemesanan->status_pemesanan) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Tanggal Pemesanan</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $pemesanan->tgl_pemesanan ? \Carbon\Carbon::parse($pemesanan->tgl_pemesanan)->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Check-in</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $pemesanan->tgl_check_in ? \Carbon\Carbon::parse($pemesanan->tgl_check_in)->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Check-out</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $pemesanan->tgl_check_out ? \Carbon\Carbon::parse($pemesanan->tgl_check_out)->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Malam</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pemesanan->total_malam }} malam</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Information Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-indigo-100 rounded-lg mr-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Informasi Kamar</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="p-3 bg-blue-100 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nomor Kamar</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $pemesanan->kamar->nomor_kamar ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="p-3 bg-green-100 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tipe Kamar</p>
                                <p class="text-xl font-semibold text-gray-900">{{ $pemesanan->kamar->tipe->nama_tipe ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Harga Per Malam</p>
                                <p class="text-xl font-semibold text-yellow-600">
                                    Rp {{ number_format($pemesanan->kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="p-3 bg-purple-100 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Status Kamar</p>
                                @php
                                    $kamarStatusClass = 'bg-red-100 text-red-800';
                                    $kamarStatusIcon = '❌';
                                    if ($pemesanan->kamar->status_ketersediaan == 'available') {
                                        $kamarStatusClass = 'bg-green-100 text-green-800';
                                        $kamarStatusIcon = '✅';
                                    } elseif ($pemesanan->kamar->status_ketersediaan == 'maintenance') {
                                        $kamarStatusClass = 'bg-yellow-100 text-yellow-800';
                                        $kamarStatusIcon = '🔧';
                                    } elseif ($pemesanan->kamar->status_ketersediaan == 'booked') {
                                        $kamarStatusClass = 'bg-blue-100 text-blue-800';
                                        $kamarStatusIcon = '🔒';
                                    }
                                @endphp
                                <span class="px-3 py-1 inline-flex items-center text-sm font-semibold rounded-full {{ $kamarStatusClass }}">
                                    <span class="mr-1">{{ $kamarStatusIcon }}</span>
                                    @if($pemesanan->kamar->status_ketersediaan == 'available')
                                        Tersedia
                                    @elseif($pemesanan->kamar->status_ketersediaan == 'booked')
                                        Dipesan
                                    @elseif($pemesanan->kamar->status_ketersediaan == 'maintenance')
                                        Pemeliharaan
                                    @else
                                        {{ ucfirst($pemesanan->kamar->status_ketersediaan) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($pemesanan->kamar->deskripsi)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-start">
                            <div class="p-3 bg-gray-100 rounded-lg mr-4">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 mb-2">Deskripsi Kamar</p>
                                <p class="text-gray-700 leading-relaxed">{{ $pemesanan->kamar->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        <!-- Guest Information -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Tamu</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Nama Pemesan</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $pemesanan->nama_pemesan ?? $pemesanan->user->nama_lengkap ?? $pemesanan->user->username }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">NIK</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $pemesanan->nik ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Nomor Telepon</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $pemesanan->nohp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Email</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $pemesanan->user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

            <!-- Booking Details Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                <div class="flex items-center mb-6">
                    <div class="p-3 bg-emerald-100 rounded-lg mr-4">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Detail Pemesanan</h2>
                </div>

                <!-- Payment Breakdown -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Rincian Pembayaran
                    </h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-700">Harga Per Malam</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($pemesanan->kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-700">Jumlah Malam</span>
                            <span class="font-semibold text-gray-900">{{ $pemesanan->total_malam }} malam</span>
                        </div>
                        <div class="border-t border-gray-300 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-gray-900">Total Harga</span>
                                <span class="text-2xl font-bold text-emerald-600">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                        <div class="flex items-center mb-3">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Metode Pembayaran</h4>
                        </div>
                        <p class="text-gray-700 ml-11">
                            @if($pemesanan->pilihan_pembayaran == 'cash')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    💵 Tunai
                                </span>
                            @elseif($pemesanan->pilihan_pembayaran == 'transfer')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    🏦 Transfer Bank
                                </span>
                            @elseif($pemesanan->pilihan_pembayaran == 'kartu_kredit')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                    💳 Kartu Kredit
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ $pemesanan->pilihan_pembayaran }}
                                </span>
                            @endif
                        </p>
                    </div>

                    @if($pemesanan->catatan)
                        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-lg p-6">
                            <div class="flex items-center mb-3">
                                <div class="p-2 bg-amber-100 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Catatan Khusus</h4>
                            </div>
                            <p class="text-gray-700 ml-11 leading-relaxed">{{ $pemesanan->catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Admin Actions -->
            @if(auth()->user()->isAdmin() && $pemesanan->status_pemesanan != 'cancelled' && $pemesanan->status_pemesanan != 'completed')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
                    <div class="flex items-center mb-6">
                        <div class="p-3 bg-rose-100 rounded-lg mr-4">
                            <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Kelola Pemesanan</h2>
                    </div>

                    <form method="POST" action="{{ route('member.pemesanan.updateStatus', $pemesanan) }}" class="bg-gray-50 rounded-lg p-6">
                        @csrf

                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <label for="status_pemesanan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status Pemesanan
                                </label>
                                <select
                                    name="status_pemesanan"
                                    id="status_pemesanan"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors"
                                >
                                    <option value="pending" @selected($pemesanan->status_pemesanan == 'pending')>⏳ Pending</option>
                                    <option value="confirmed" @selected($pemesanan->status_pemesanan == 'confirmed')>✅ Confirmed</option>
                                    <option value="cancelled">❌ Cancelled</option>
                                    <option value="completed" @selected($pemesanan->status_pemesanan == 'completed')>🏁 Completed</option>
                                </select>
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Back Button -->
            <div class="flex flex-col sm:flex-row gap-4">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('member.pemesanan.my') }}" class="flex-1 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-800 font-semibold py-4 px-6 rounded-xl transition-all duration-200 text-center shadow-sm border border-gray-300 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Pemesanan
                    </a>
                @else
                    <a href="{{ route('member.pemesanan.my') }}" class="flex-1 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-800 font-semibold py-4 px-6 rounded-xl transition-all duration-200 text-center shadow-sm border border-gray-300 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Pemesanan Saya
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
    </div>
@endsection
