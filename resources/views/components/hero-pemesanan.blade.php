@props([
    'title' => 'Riwayat Pemesanan',
    'subtitle' => 'Kelola Pesanan Anda',
    'description' => 'Pantau dan kelola semua riwayat pemesanan kamar hotel Anda dengan mudah.',
    'image' => 'user/GambarHeroSection.jpg',
    'ctaText' => 'Lihat Semua Pesanan',
    'ctaLink' => '#',
    'pemesanan' => null, // Collection of bookings for stats
    'splitPercent' => 55, // Modified split for booking history
    'angle' => 75, // Modified angle - different direction for yellow elements
    'bgHex' => '#E3A008' // Default to gold-500 from palette
])

<section class="relative w-full min-h-[600px] lg:h-[80vh] flex items-center overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-black pt-24 lg:pt-32">
    {{-- Background with Diagonal Split using Linear Gradient --}}
    <div class="absolute inset-0 z-0 hidden lg:block parallax"
         style="background: linear-gradient({{ $angle }}deg, {{ $bgHex }} 0%, {{ $bgHex }} {{ $splitPercent }}%, transparent {{ $splitPercent }}.1%, transparent 100%), url('{{ asset($image) }}');
                background-size: cover;
                background-position: center;"
         data-parallax="0.3">
        {{-- Overlay for better text readability --}}
        <div class="absolute inset-0 bg-black bg-opacity-10"></div>
    </div>

    {{-- Mobile Background (Stacked) --}}
    <div class="absolute inset-0 z-0 lg:hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-600 to-yellow-800 opacity-95 z-10"></div>
        <img src="{{ asset($image) }}" class="absolute inset-0 w-full h-full object-cover opacity-20 z-0" alt="Background">
        {{-- Mobile overlay --}}
        <div class="absolute inset-0 bg-black bg-opacity-30 z-5"></div>
    </div>



    {{-- Content Container --}}
    <div class="relative z-10 max-w-[120rem] mx-auto px-4 sm:px-6 lg:px-8 w-full h-full flex items-center">
        {{-- Dynamic Width based on splitPercent for Desktop --}}
        <div class="w-full lg:w-[{{ $splitPercent }}%] py-16 lg:py-0 transform transition-all duration-1000 ease-out" style="@media (min-width: 1024px) { width: {{ $splitPercent }}%; }">
             {{-- Subtitle --}}
             <div class="inline-flex items-center px-4 py-2 bg-white backdrop-blur-sm rounded-full border border-yellow-400 border-opacity-30 mb-6">
                 <span class="text-sm font-bold tracking-widest uppercase text-yellow-600">
                     {{ $subtitle }}
                 </span>

             </div>

             {{-- Title --}}
             <h1 class="max-w-3xl text-4xl md:text-5xl lg:text-6xl font-black leading-tight mb-6 text-white drop-shadow-2xl">
                 <span class="bg-gradient-to-r from-white via-white to-white bg-clip-text text-transparent">
                     {!! nl2br(e($title)) !!}
                 </span>
             </h1>

             {{-- Description --}}
             <p class="text-lg md:text-xl mb-8 text-gray-700 max-w-2xl leading-relaxed font-medium drop-shadow-lg">
                 {{ $description }}
             </p>

             {{-- CTA Button --}}
             @if($ctaText)
             <div class="flex flex-col sm:flex-row gap-4">
                 <a href="{{ $ctaLink }}" class="group inline-flex items-center px-8 py-4 bg-white hover:from-yellow-600 hover:to-yellow-700 text-black font-bold rounded-full transition-all duration-300 shadow-2xl shadow-yellow-500/30 hover:shadow-yellow-500/50 transform hover:-translate-y-1 hover:scale-105">
                     <span class="mr-3">{{ $ctaText }}</span>
                     <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                     </svg>
                 </a>

                 {{-- Secondary CTA --}}
                 <a href="{{ route('daftarkamar') }}" class="inline-flex items-center px-8 py-4 border-2 border-white border-opacity-30 text-white font-semibold rounded-full hover:bg-white hover:bg-opacity-10 transition-all duration-300 backdrop-blur-sm">
                     <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                     </svg>
                     Pesan Kamar Baru
                 </a>
             </div>
             @endif

             {{-- Interactive Quick Stats --}}
             @if($pemesanan)
             <div class="mt-10 grid grid-cols-3 gap-6 max-w-md">
                 <div class="text-center cursor-pointer group transition-all duration-300 hover:scale-105" onclick="filterBookings('all')">
                     <div class="text-2xl font-bold text-yellow-400 mb-1 group-hover:text-yellow-300 transition-colors">{{ $pemesanan->count() }}</div>
                     <div class="text-sm text-gray-300 uppercase tracking-wide group-hover:text-white transition-colors">Total Pesanan</div>
                 </div>
                 <div class="text-center cursor-pointer group transition-all duration-300 hover:scale-105" onclick="filterBookings('confirmed')">
                     <div class="text-2xl font-bold text-yellow-400 mb-1 group-hover:text-yellow-300 transition-colors">{{ $pemesanan->where('status_pemesanan', 'confirmed')->count() }}</div>
                     <div class="text-sm text-gray-300 uppercase tracking-wide group-hover:text-white transition-colors">Dikonfirmasi</div>
                 </div>
                 <div class="text-center cursor-pointer group transition-all duration-300 hover:scale-105" onclick="filterBookings('completed')">
                     <div class="text-2xl font-bold text-yellow-400 mb-1 group-hover:text-yellow-300 transition-colors">{{ $pemesanan->where('status_pemesanan', 'completed')->count() }}</div>
                     <div class="text-sm text-gray-300 uppercase tracking-wide group-hover:text-white transition-colors">Selesai</div>
                 </div>
             </div>
             @endif
        </div>
    </div>


</section>
