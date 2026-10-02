@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Member</h1>
        <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-50 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-blue-500 rounded-full p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>

        <div class="bg-green-50 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-green-500 rounded-full p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Completed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $completedBookings }}</p>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-yellow-500 rounded-full p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingBookings }}</p>
                </div>
            </div>
        </div>

        <div class="bg-purple-50 rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="bg-purple-500 rounded-full p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Wishlist</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $wishlistCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Bookings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Bookings</h3>
                <a href="{{ route('member.pemesanan.my') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
            </div>
            @if($recentBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($recentBookings as $booking)
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">{{ $booking->kamar->nomor_kamar }} - {{ $booking->kamar->tipe->nama_tipe }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->tgl_check_in ? \Carbon\Carbon::parse($booking->tgl_check_in)->format('d M Y') : 'N/A' }} - {{ $booking->tgl_check_out ? \Carbon\Carbon::parse($booking->tgl_check_out)->format('d M Y') : 'N/A' }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            @if($booking->status_pemesanan == 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status_pemesanan == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status_pemesanan == 'completed') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($booking->status_pemesanan) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No recent bookings</p>
            @endif
        </div>

        <!-- Recent Reviews -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recent Reviews</h3>
                <a href="{{ route('member.reviews.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
            </div>
            @if($recentReviews->count() > 0)
                <div class="space-y-4">
                    @foreach($recentReviews as $review)
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">{{ $review->kamar->nomor_kamar }} - {{ $review->kamar->tipe->nama_tipe }}</span>
                        </div>
                        <p class="text-sm text-gray-700">{{ Str::limit($review->komentar, 100) }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No reviews yet</p>
            @endif
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
            <span class="text-sm text-gray-500">Last 30 days</span>
        </div>
        <div class="space-y-4">
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="bg-blue-100 rounded-full p-2 mr-3">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Booking Confirmed</p>
                    <p class="text-xs text-gray-600">Your booking for Deluxe Room has been confirmed</p>
                </div>
                <span class="text-xs text-gray-500">2 days ago</span>
            </div>

            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="bg-green-100 rounded-full p-2 mr-3">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Review Submitted</p>
                    <p class="text-xs text-gray-600">You left a 5-star review for Suite Room</p>
                </div>
                <span class="text-xs text-gray-500">1 week ago</span>
            </div>

            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="bg-purple-100 rounded-full p-2 mr-3">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Added to Wishlist</p>
                    <p class="text-xs text-gray-600">Presidential Suite added to your wishlist</p>
                </div>
                <span class="text-xs text-gray-500">2 weeks ago</span>
            </div>
        </div>
    </div>

    <!-- Special Offers -->
    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-lg shadow-md p-6 mt-8">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-white mb-2">Exclusive Member Offer</h3>
                <p class="text-yellow-100 text-sm mb-4">Get 20% off on your next booking! Use code MEMBER20 at checkout.</p>
                <div class="flex items-center text-xs text-white">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Valid until December 31, 2024
                </div>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-yellow-200" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <!-- Menu: Daftar Kamar -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center mb-4">
                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 ml-3">Daftar Kamar</h3>
            </div>
            <p class="text-gray-600 mb-4">Lihat dan pilih kamar yang tersedia untuk dipesan</p>
            <a href="{{ route('member.kamar.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Lihat Kamar
            </a>
        </div>

        <!-- Menu: Riwayat Pemesanan -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center mb-4">
                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 ml-3">Riwayat Pemesanan</h3>
            </div>
            <p class="text-gray-600 mb-4">Cek status dan detail riwayat pemesanan Anda</p>
            <a href="{{ route('member.pemesanan.my') }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Lihat Riwayat
            </a>
        </div>

        <!-- Menu: Profil -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex items-center mb-4">
                <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 ml-3">Profil Saya</h3>
            </div>
            <p class="text-gray-600 mb-4">Kelola informasi pribadi dan pengaturan akun Anda</p>
            <a href="{{ route('member.profile.show') }}" class="inline-block bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">
                Lihat Profil
            </a>
        </div>
    </div>
</div>

<script>
function toggleSection(header) {
    const section = header.closest('.collapsible-section');
    const content = section.querySelector('.collapsible-content');
    const icon = header.querySelector('svg');

    content.classList.toggle('collapsed');
    icon.classList.toggle('rotate-180');
}
</script>

<style>
.collapsible-content {
    max-height: 1000px;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.collapsible-content.collapsed {
    max-height: 0;
}

.rotate-180 {
    transform: rotate(180deg);
}
</style>
@endsection
