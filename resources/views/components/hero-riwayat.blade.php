@props([
    'title' => 'Order History',
    'subtitle' => 'Booking Management',
    'description' => 'Manage and view all your hotel room booking history.',
    'image' => 'user/lobbyhtl.jpg',
    'ctaText' => 'View All Bookings',
    'ctaLink' => '#',
    'splitPercent' => 50, // Default split at 50% width
    'angle' => 105, // Default angle
    'bgHex' => '#E3A008' // Default to gold-500 from palette
])

<section class="relative w-full min-h-[700px] lg:h-screen flex items-center overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-black pt-24 lg:pt-32">
    {{-- Background with Diagonal Split using Linear Gradient --}}
    <div class="absolute inset-0 z-0 hidden lg:block parallax"
         style="background: linear-gradient({{ $angle }}deg, {{ $bgHex }} 0%, {{ $bgHex }} {{ $splitPercent }}%, transparent {{ $splitPercent }}.1%, transparent 100%), url('{{ $image }}');
                background-size: cover;
                background-position: center;"
         data-parallax="0.3">
        {{-- Overlay for better text readability --}}
        <div class="absolute inset-0 bg-black bg-opacity-5"></div>
    </div>

    {{-- Mobile Background (Stacked) --}}
    <div class="absolute inset-0 z-0 lg:hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-yellow-600 to-yellow-800 opacity-95 z-10"></div>
        <img src="{{ $image }}" class="absolute inset-0 w-full h-full object-cover opacity-20 z-0" alt="Background">
        {{-- Mobile overlay --}}
        <div class="absolute inset-0 bg-black bg-opacity-30 z-5"></div>
    </div>



    {{-- Content Container --}}
    <div class="relative z-10 max-w-[120rem] mx-auto px-4 sm:px-6 lg:px-8 w-full h-full flex items-center">
        {{-- Dynamic Width based on splitPercent for Desktop --}}
        <div class="w-full lg:w-[{{ $splitPercent }}%] py-20 lg:py-0 transform transition-all duration-1000 ease-out" style="@media (min-width: 1024px) { width: {{ $splitPercent }}%; }">
             {{-- Subtitle --}}
             <div class="inline-flex items-center px-4 py-2 bg-white backdrop-blur-sm rounded-full border border-yellow-400 border-opacity-30 mb-6">
                 <span class="text-sm font-bold tracking-widest uppercase text-yellow-600">
                     {{ $subtitle }}
                 </span>
                 <div class="w-2 h-2 bg-yellow-600 rounded-full ml-3 animate-pulse"></div>
             </div>

             {{-- Title --}}
             <h1 class="max-w-3xl text-4xl md:text-6xl lg:text-7xl font-black leading-tight mb-8 text-white drop-shadow-2xl">
                 <span class="bg-gradient-to-r from-white via-white to-white bg-clip-text text-transparent">
                     {!! nl2br(e($title)) !!}
                 </span>
             </h1>

             {{-- Description --}}
             <p class="text-lg md:text-xl mb-10 text-gray-700 max-w-2xl leading-relaxed font-medium drop-shadow-lg">
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
             </div>
             @endif
        </div>
    </div>


</section>
