<div>
    {{-- Search and Filter Section --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
            {{-- Search Input --}}
            <div class="lg:col-span-2">
                <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Cari Kamar</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" id="search"
                           placeholder="Cari berdasarkan nomor kamar atau tipe..."
                           class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Room Type Filter --}}
            <div>
                <label for="tipe_kamar" class="block text-xs font-medium text-gray-700 mb-1">Tipe Kamar</label>
                <div class="relative">
                    <select wire:model.live="tipe_kamar" id="tipe_kamar"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                        <option value="">Semua Tipe</option>
                        @foreach($tipeKamarOptions as $tipe)
                            <option value="{{ $tipe->id_tipe }}">{{ $tipe->nama_tipe }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Availability Filter --}}
            <div>
                <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                <div class="relative">
                    <select wire:model.live="status" id="status"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                        <option value="">Semua Status</option>
                        <option value="available">Tersedia</option>
                        <option value="unavailable">Tidak Tersedia</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Price Range and Sort --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
            <div>
                <label for="harga_min" class="block text-xs font-medium text-gray-700 mb-1">Harga Min</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-400 font-medium text-sm">Rp</span>
                    </div>
                    <input type="number" wire:model.live.debounce.300ms="harga_min" id="harga_min"
                           placeholder="0"
                           class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                </div>
            </div>
            <div>
                <label for="harga_max" class="block text-xs font-medium text-gray-700 mb-1">Harga Max</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-400 font-medium text-sm">Rp</span>
                    </div>
                    <input type="number" wire:model.live.debounce.300ms="harga_max" id="harga_max"
                           placeholder="9999999"
                           class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                </div>
            </div>
            <div>
                <label for="sort" class="block text-xs font-medium text-gray-700 mb-1">Urutkan</label>
                <div class="relative">
                    <select wire:model.live="sort" id="sort"
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none">
                        <option value="latest">Terbaru</option>
                        <option value="name">Nama (A-Z)</option>
                        <option value="price_low">Harga Rendah</option>
                        <option value="price_high">Harga Tinggi</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-3 pt-3 border-t border-gray-100 mt-3">
            <button type="button"
                    wire:click="$set('search', ''); $set('tipe_kamar', ''); $set('status', ''); $set('harga_min', ''); $set('harga_max', ''); $set('sort', 'latest')"
                    class="inline-flex items-center justify-center px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-md transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Reset
            </button>
            @if($wishlists->total() > 0)
                <div class="text-xs text-gray-600 flex items-center ml-auto">
                    <span>{{ $wishlists->total() }} hasil ditemukan</span>
                </div>
            @endif
        </div>
    </div>

    @if($wishlists->count() > 0)
        {{-- Wishlist Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($wishlists as $wishlist)
                <x-room-card :kamar="$wishlist->kamar" :showWishlist="true" />
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($wishlists->hasPages())
            <div class="mt-8">
                {{ $wishlists->links() }}
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Wishlist Kosong</h3>
            <p class="text-gray-600 mb-6">Anda belum menambahkan kamar favorit ke wishlist. Jelajahi kamar kami dan tambahkan yang Anda suka!</p>
            <a href="{{ route('member.kamar.index') }}"
               class="inline-flex items-center px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Jelajahi Kamar
            </a>
        </div>
    @endif


</div>
