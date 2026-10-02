@extends('layouts.app')

@section('page_title', 'Riwayat Pemesanan')

@section('content')
<x-hero-pemesanan
    :pemesanan="$pemesanan"
    title="Riwayat Pemesanan"
    subtitle="Kelola Pesanan Anda"
    description="Pantau dan kelola semua riwayat pemesanan kamar hotel Anda dengan mudah."
    image="user/GambarHeroSection.jpg"
    ctaText="Lihat Semua Pesanan"
    ctaLink="#booking-list"
    splitPercent="55"
    angle="75"
    bgHex="#E3A008"
/>

<div id="booking-list" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Order History</h1>
        <p class="text-gray-600">Manage and view all your hotel room booking history.</p>
    </div>

    <!-- Search Bar -->
    <div class="mb-8">
        <form method="GET" action="{{ route('member.pemesanan.my') }}" class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by booking code, name, or room..." class="w-full bg-gray-100 border-none rounded-lg py-3 px-4 pl-12 text-gray-700 focus:ring-2 focus:ring-yellow-500 focus:bg-white transition">
            <div class="absolute left-4 top-3.5 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            @if(request('search'))
                <a href="{{ route('member.pemesanan.my') }}" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            @endif
        </form>
    </div>

    <!-- Tabs -->
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-xl mb-8 overflow-x-auto">
        <a href="{{ route('member.pemesanan.my', request()->only(['search'])) }}"
           class="flex-1 py-2.5 px-4 rounded-lg text-center font-medium text-sm transition {{ !request('status') ? 'bg-yellow-500 text-white shadow-sm' : 'text-gray-600 hover:bg-white hover:shadow-sm' }}">
            All Orders
        </a>
        <a href="{{ route('member.pemesanan.my', array_merge(request()->only(['search']), ['status' => 'upcoming'])) }}"
           class="flex-1 py-2.5 px-4 rounded-lg text-center font-medium text-sm transition {{ request('status') === 'upcoming' ? 'bg-yellow-500 text-white shadow-sm' : 'text-gray-600 hover:bg-white hover:shadow-sm' }}">
            Upcoming
        </a>
        <a href="{{ route('member.pemesanan.my', array_merge(request()->only(['search']), ['status' => 'completed'])) }}"
           class="flex-1 py-2.5 px-4 rounded-lg text-center font-medium text-sm transition {{ request('status') === 'completed' ? 'bg-yellow-500 text-white shadow-sm' : 'text-gray-600 hover:bg-white hover:shadow-sm' }}">
            Completed
        </a>
        <a href="{{ route('member.pemesanan.my', array_merge(request()->only(['search']), ['status' => 'cancelled'])) }}"
           class="flex-1 py-2.5 px-4 rounded-lg text-center font-medium text-sm transition {{ request('status') === 'cancelled' ? 'bg-yellow-500 text-white shadow-sm' : 'text-gray-600 hover:bg-white hover:shadow-sm' }}">
            Cancelled
        </a>
    </div>

    <!-- Active Filters Info -->
    @if(request('search') || request('status'))
    <div class="mb-6 flex flex-wrap items-center gap-2">
        <span class="text-sm text-gray-600">Active filters:</span>
        @if(request('search'))
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                Search: "{{ request('search') }}"
                <a href="{{ route('member.pemesanan.my', array_merge(request()->only(['status']), [])) }}" class="ml-2 text-yellow-600 hover:text-yellow-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            </span>
        @endif
        @if(request('status'))
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                Status: {{ ucfirst(request('status')) }}
                <a href="{{ route('member.pemesanan.my', array_merge(request()->only(['search']), [])) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            </span>
        @endif
        <a href="{{ route('member.pemesanan.my') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">Clear all filters</a>
    </div>
    @endif

    <!-- Booking List -->
    <div class="space-y-6">
        @forelse($pemesanan as $booking)
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Room Image (Placeholder if none) -->
                <div class="w-full md:w-48 h-32 bg-gray-200 rounded-xl overflow-hidden flex-shrink-0">
                    @if($booking->kamar->foto_kamar)
                        <img src="{{ asset('storage/' . $booking->kamar->foto_kamar) }}" alt="Room" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                <!-- Details -->
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $booking->nama_pemesan }}</h3>
                            <p class="text-gray-500 text-sm">Kamar {{ $booking->kamar->nomor_kamar }} • {{ $booking->kamar->tipe->nama_tipe }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                            @if($booking->status_pemesanan == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status_pemesanan == 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status_pemesanan == 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($booking->status_pemesanan) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Check-in: {{ $booking->tgl_check_in ? \Carbon\Carbon::parse($booking->tgl_check_in)->format('d M Y') : 'N/A' }}
                        </div>
                        <div class="flex items-center text-gray-600 text-sm">
                            <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Check-out: {{ $booking->tgl_check_out ? \Carbon\Carbon::parse($booking->tgl_check_out)->format('d M Y') : 'N/A' }}
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="bg-yellow-50 px-4 py-2 rounded-lg w-full md:w-auto">
                            <span class="text-xs text-gray-500 block">Total Payment</span>
                            <span class="text-lg font-bold text-yellow-700">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex gap-3 w-full md:w-auto">
                            @if($booking->status_pemesanan == 'pending')
                                <form action="{{ route('member.pemesanan.cancel', $booking->id_pemesanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full md:w-auto px-6 py-2.5 border border-red-200 text-red-600 font-medium rounded-lg hover:bg-red-50 transition">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                            @if($booking->status_pemesanan == 'completed')
                                <a href="{{ route('daftarkamar.show', $booking->kamar->id_kamar) }}" class="w-full md:w-auto px-6 py-2.5 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition text-center shadow-md shadow-green-200">
                                    Leave Review
                                </a>
                            @endif
                            <a href="{{ route('member.pemesanan.show', $booking->id_pemesanan) }}" class="w-full md:w-auto px-6 py-2.5 bg-yellow-500 text-white font-medium rounded-lg hover:bg-yellow-600 transition text-center shadow-md shadow-yellow-200">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white rounded-2xl border border-gray-200">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            @if(request('search') || request('status'))
                <h3 class="text-lg font-medium text-gray-900">No matching bookings found</h3>
                <p class="text-gray-500 mt-1">No bookings match your current search and filter criteria.</p>
                <a href="{{ route('member.pemesanan.my') }}" class="inline-block mt-4 px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                    Clear Filters
                </a>
            @else
                <h3 class="text-lg font-medium text-gray-900">No bookings found</h3>
                <p class="text-gray-500 mt-1">You haven't made any room bookings yet.</p>
                <a href="{{ route('member.kamar.index') }}" class="inline-block mt-4 px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                    Book a Room
                </a>
            @endif
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $pemesanan->links() }}
    </div>
</div>
@endsection
