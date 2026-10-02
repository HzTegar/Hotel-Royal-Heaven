@extends('layouts.app')

@section('page_title', 'Wishlist Saya')

@section('content')
{{-- Hero Section --}}
<x-hero-wishlist
    title="Your Favorite Rooms"
    subtitle="Personal Collection"
    description="Keep track of your favorite rooms and plan your perfect stay with ease."
    image="/user/wishlist (1).jpg"
    ctaText="Explore More Rooms"
    :ctaLink="route('member.kamar.index')"
/>

<div class="min-h-screen bg-gray-50 -mt-24 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Wishlist Filter and Results --}}
        <livewire:wishlist-filter />
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
</div>

<script>
    let selectedKamarId = null;

    function openBookingModal(kamarId) {
        selectedKamarId = kamarId;
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
            window.livewire.find('booking-form').set('selectedKamarId', kamarId);
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
            selectedKamarId = null;
        }, 300);
    }

    // Event listeners
    document.getElementById('closeModalBtn').addEventListener('click', closeBookingModal);
    document.getElementById('modalBackdrop').addEventListener('click', closeBookingModal);

    // Listen for booking success event
    window.addEventListener('booking-success', function() {
        closeBookingModal();
    });
</script>
@endsection
