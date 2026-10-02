@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')

{{-- TEMPATKAN PEMANGGILAN NAVBAR ANDA DI SINI --}}
@include('components.herosectionkamar')

{{-- Search/Filter Bar --}}
<div id="main-content" class="relative z-30 -mt-16 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <x-filter-section
        title="Find Your Perfect Stay"
        :showSearch="true"
        :showTypeFilter="true"
        :showSortFilter="true"
        :showPriceFilter="true"
        searchPlaceholder="Search by room name or type..."
        :tipeKamars="$tipeKamars ?? []"
    />
</div>

{{-- Room List Content --}}
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
    {{-- Grid Kamar (grid-cols-5) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        @forelse($kamars ?? [] as $kamar)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col">
                {{-- Image --}}
                <div class="h-64 w-full overflow-hidden bg-gray-200 relative">
                    @if($kamar->foto_kamar)
                        <img src="{{ asset('storage/' . $kamar->foto_kamar) }}" alt="{{ $kamar->nomor_kamar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-sm">
                        {{ $kamar->tipe->nama_tipe }}
                    </div>
                    {{-- Status Badge --}}
                    <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold uppercase shadow-sm
                        @if(($kamar->status_ketersediaan ?? 'booked') == 'available')
                            bg-green-500 text-white
                        @else
                            bg-red-500 text-white
                        @endif">
                        {{ ucfirst($kamar->status_ketersediaan ?? 'Booked') }}
                    </span>
                </div>

                {{-- Content --}}
                <div class="p-4 bg-gray-100/50 flex flex-col flex-grow">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Kamar {{ $kamar->nomor_kamar }}</h3>
                    <p class="text-gray-500 text-xs line-clamp-2 mb-3 flex-grow">
                        {{ $kamar->deskripsi ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Perfect comfort with our selection of luxury hotel rooms.' }}
                    </p>

                    <div class="flex flex-col gap-1 mb-3">
                        <span class="text-xs font-semibold text-yellow-600 uppercase tracking-wider">Price</span>
                        <span class="text-sm font-bold text-gray-900">Rp {{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}</span>
                    </div>

                    {{-- Wishlist Button --}}
                    @auth
                        @if(auth()->user()->role === 'member')
                            @php
                                $inWishlist = $kamar->wishlists()->where('id_user', auth()->id())->exists();
                            @endphp
                            <button
                                id="wishlist-btn-{{ $kamar->id_kamar }}"
                                data-in-wishlist="{{ $inWishlist ? 'true' : 'false' }}"
                                data-kamar-id="{{ $kamar->id_kamar }}"
                                class="w-full mb-2 {{ $inWishlist ? 'bg-red-500 hover:bg-red-600' : 'bg-gray-500 hover:bg-gray-600' }} text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span id="wishlist-text-{{ $kamar->id_kamar }}">{{ $inWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}</span>
                            </button>
                        @endif
                    @endauth

                    <div class="grid grid-cols-2 gap-2 mt-auto">
                        <a href="{{ route('member.kamar.show', $kamar) }}" class="px-2 py-2 text-center text-xs font-semibold text-gray-700 border border-gray-300 rounded-lg hover:bg-white hover:border-gray-400 transition">
                            Detail
                        </a>
                        @if(($kamar->status_ketersediaan ?? 'booked') == 'available')
                            <button onclick="openBookingModal({{ $kamar->id_kamar }})" class="px-2 py-2 text-center text-xs font-semibold text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition shadow-md shadow-yellow-200">
                                Book
                            </button>
                        @else
                            <button disabled class="px-2 py-2 text-center text-xs font-semibold text-white bg-red-400 rounded-lg cursor-not-allowed opacity-70">
                                Booked
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-2xl shadow-2xl border border-gray-100">
                <p class="text-3xl font-bold text-gray-900 mb-2">Tidak ada Kamar Ditemukan</p>
                <p class="text-gray-500 text-lg">Saat ini tidak ada kamar yang terdaftar atau tersedia untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-16 flex justify-center">
        {{ $kamars->links() ?? '' }}
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
                                Pilih kamar dan lengkapi data pemesanan
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
                <livewire:booking-form :selectedKamarId="$selectedKamarId ?? null" />
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

    // Wishlist functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Handle all wishlist buttons
        document.querySelectorAll('[id^="wishlist-btn-"]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                const kamarId = event.target.getAttribute('data-kamar-id');
                const isInWishlist = event.target.getAttribute('data-in-wishlist') === 'true';
                const wishlistText = document.getElementById('wishlist-text-' + kamarId);

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
        });

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
