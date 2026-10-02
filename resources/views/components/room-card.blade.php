@props([
    'kamar',
    'showWishlist' => false,
    'showBooking' => true,
    'showSpecs' => true,
    'cardClass' => 'bg-white rounded-lg shadow-md hover:shadow-lg overflow-hidden transition-all duration-300 border border-gray-200'
])

<div class="{{ $cardClass }}">
    {{-- Room Image --}}
    <div class="relative overflow-hidden group">
        @php
            $images = [];
            if ($kamar->foto_kamar) {
                $images[] = $kamar->foto_kamar;
            }
            if ($kamar->foto_detail && is_array($kamar->foto_detail)) {
                $images = array_merge($images, $kamar->foto_detail);
            }
        @endphp

        @if(count($images) > 0)
            <img src="{{ asset('storage/' . $images[0]) }}"
                 alt="{{ $kamar->nomor_kamar }}"
                 class="w-full h-20 object-cover">
        @else
            <div class="w-full h-20 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p class="text-gray-500 text-sm font-medium">No Image</p>
                </div>
            </div>
        @endif

        {{-- Status Badge --}}
        <div class="absolute top-4 right-4">
            @if($kamar->status_ketersediaan === 'available')
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-500 text-white">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Available
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-500 text-white">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    Booked
                </span>
            @endif
        </div>

        {{-- Wishlist Button (if enabled) --}}
        @if($showWishlist)
            <div class="absolute top-4 left-4">
                <button class="p-2 rounded-full bg-white/90 hover:bg-white text-gray-600 hover:text-red-500 transition-all duration-200 shadow-lg backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>
        @endif


    </div>

    {{-- Card Content --}}
    <div class="p-3">
        {{-- Room Title and Type --}}
        <div class="mb-2">
            <h3 class="text-sm font-bold text-gray-900 mb-1">{{ $kamar->nomor_kamar }}</h3>
            <p class="text-xs font-medium text-yellow-600 uppercase tracking-wide">{{ $kamar->tipe->nama_tipe }}</p>
        </div>

        {{-- Room Specifications (if enabled) --}}
        @if($showSpecs)
            <div class="flex items-center justify-between text-xs text-gray-600 mb-2 p-1 bg-gray-50 rounded">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    {{ $kamar->tipe->kapasitas }}
                </div>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    {{ $kamar->tipe->luas }}m²
                </div>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    {{ $kamar->tipe->tempat_tidur }}
                </div>
            </div>
        @endif

        {{-- Price --}}
        <div class="text-center mb-2">
            <div class="text-lg font-bold text-gray-900 mb-1">
                Rp {{ number_format($kamar->tipe->harga_dasar, 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-600">per night</div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex space-x-1">
            {{-- Detail Button --}}
            <a href="{{ route('daftarkamar.show', $kamar) }}"
               class="flex-1 text-center px-2 py-1 rounded text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium text-xs transition-all duration-200">
                Details
            </a>

            {{-- Booking Button --}}
            @if($showBooking)
                @if($kamar->status_ketersediaan === 'available')
                    @auth
                        @if(auth()->user()->role === 'member')
                            <button onclick="openBookingModal({{ $kamar->id_kamar }})"
                                   class="flex-1 text-center px-2 py-1 rounded bg-yellow-500 hover:bg-yellow-600 text-white font-medium text-xs transition-all duration-200">
                                Book
                            </button>
                        @endif
                    @endauth
                    @guest
                        <a href="{{ route('login') }}"
                           class="flex-1 text-center px-2 py-1 rounded bg-yellow-500 hover:bg-yellow-600 text-white font-medium text-xs transition-all duration-200">
                            Book
                        </a>
                    @endguest
                @else
                    <button disabled
                            class="flex-1 text-center px-2 py-1 rounded bg-gray-300 text-gray-500 font-medium text-xs cursor-not-allowed">
                        N/A
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>
