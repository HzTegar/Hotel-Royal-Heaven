@extends('layouts.app')

@section('page_title', 'Home')

@section('content')

{{-- Pastikan Anda tidak memiliki tag <body> atau </head> yang terbuka atau tertutup di sini 
karena sudah ada di 'layouts.app' --}}

    {{-- Header dipisah ke komponen --}}
    

    {{-- HERO SECTION --}}
    {{-- Consistent design with other hero sections --}}
    <section class="relative w-full min-h-[700px] lg:h-screen flex items-center overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-black pt-24 lg:pt-32">
        {{-- Background with Diagonal Split using Linear Gradient --}}
        <div class="absolute inset-0 z-0 hidden lg:block parallax"
             style="background: linear-gradient(105deg, #E3A008 0%, #E3A008 50%, transparent 50.1%, transparent 100%), url('{{ asset('user/GambarHeroSection.jpg') }}');
                    background-size: cover;
                    background-position: center;"
             data-parallax="0.3">
            {{-- Overlay for better text readability --}}
            <div class="absolute inset-0 bg-black bg-opacity-5"></div>
        </div>

        {{-- Mobile Background (Stacked) --}}
        <div class="absolute inset-0 z-0 lg:hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-yellow-600 to-yellow-800 opacity-95 z-10"></div>
            <img src="{{ asset('user/GambarHeroSection.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-20 z-0" alt="Background">
            {{-- Mobile overlay --}}
            <div class="absolute inset-0 bg-black bg-opacity-30 z-5"></div>
        </div>



        {{-- Content Container --}}
        <div class="relative z-10 max-w-[120rem] mx-auto px-4 sm:px-6 lg:px-8 w-full h-full flex items-center">
            {{-- Dynamic Width based on splitPercent for Desktop --}}
            <div class="w-full lg:w-[50%] py-20 lg:py-0 transform transition-all duration-1000 ease-out">
                 {{-- Subtitle --}}
                 <div class="inline-flex items-center px-4 py-2 bg-white backdrop-blur-sm rounded-full border border-yellow-400 border-opacity-30 mb-6">
                     <span class="text-sm font-bold tracking-widest uppercase text-yellow-600">
                         The Ultimate Luxury Experience
                     </span>

                 </div>

                 {{-- Title --}}
                 <h1 class="max-w-3xl text-4xl md:text-6xl lg:text-7xl font-black leading-tight mb-8 text-white drop-shadow-2xl">
                     <span class="bg-gradient-to-r from-white via-white to-white bg-clip-text text-transparent">
                         Hotel for Every Moment Rich in Money
                     </span>
                 </h1>

                 {{-- Description --}}
                 <p class="text-lg md:text-xl mb-10 text-gray-700 max-w-2xl leading-relaxed font-medium drop-shadow-lg">
                     A hotel that has been established for a long time and has a cool be used as a family vacation spot.
                 </p>

                 {{-- CTA Button --}}
                 <div class="flex flex-col sm:flex-row gap-4">
                     <a href="{{ route('about') }}" class="group inline-flex items-center px-8 py-4 bg-white hover:from-yellow-600 hover:to-yellow-700 text-black font-bold rounded-full transition-all duration-300 shadow-2xl shadow-yellow-500/30 hover:shadow-yellow-500/50 transform hover:-translate-y-1 hover:scale-105">
                         <span class="mr-3">Know More About Hotel</span>
                         <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                         </svg>
                     </a>
                 </div>
            </div>
        </div>


    </section>
        
    <hr class="max-w-7xl mx-auto border-gray-200 my-8">

    {{-- START: A Little About Us Section (Mengambil desain dari kode kedua Anda) --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-on-scroll">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

            {{-- Kiri: Teks dan Deskripsi --}}
            <div class="pr- lg:pr-6">
                <h2 class="text-3xl font-extrabold mb-3 text-gray-900">
                    A <span class="text-yellow-500">little</span> about us
                </h2>
                <p class="text-base text-gray-600 leading-relaxed mb-4">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut perspiciatis unde omnis iste
                    natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.
                </p>
                <p class="text-base text-gray-600 leading-relaxed">
                    Kami adalah Royal Heaven, destinasi terbaik untuk pengalaman menginap mewah dan tak terlupakan.
                    Setiap detail kami rancang untuk kenyamanan Anda.
                </p>
            </div>

            {{-- Kanan: Grid Gambar (Diambil dari kode kedua Anda) --}}
            <div class="image-gallery grid grid-cols-2 grid-rows-2 gap-4 min-h-[300px]">

                {{-- Placeholder Atas Kiri --}}
                <div class="rounded-2xl h-48 bg-gray-300 relative overflow-hidden">
                    <img src="{{ asset('user/ruangkanan.jpg') }}" alt="Kamar Deluxe" class="absolute inset-0 w-full h-full object-cover lazy" data-src="{{ asset('user/ruangkanan.jpg') }}">
                </div>

                {{-- Placeholder Atas Kanan --}}
                <div class="rounded-2xl h-48 bg-gray-300 relative overflow-hidden">
                    <img src="{{ asset('user/ruangkiri.jpg') }}" alt="Kolam Renang" class="absolute inset-0 w-full h-full object-cover lazy" data-src="{{ asset('user/ruangkiri.jpg') }}">
                </div>

                {{-- Placeholder Besar Bawah (Col Span 2) --}}
                <div class="col-span-2 rounded-2xl h-48 bg-gray-300 relative overflow-hidden">
                    <img src="{{ asset('user/fotoblokbawah.avif') }}" alt="Lobi Hotel Utama" class="absolute inset-0 w-full h-full object-cover lazy" data-src="{{ asset('user/fotoblokbawah.avif') }}">
                </div>
            </div>

        </div>
    </section>
    {{-- END: A Little About Us Section --}}

    <hr class="max-w-7xl mx-auto border-gray-200 my-8">

    {{-- Popular Rooms Section (Menggunakan variabel $featured_kamar yang BENAR) --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-3xl font-serif font-bold text-center text-gray-900 mb-12">Our Most Popular Rooms</h2>
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            
            {{-- Loop data: WAJIB DISEDIAKAN oleh Controller Anda --}}
            @foreach($featured_kamar as $room)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col">
                {{-- Image --}}
                <div class="h-64 w-full overflow-hidden bg-gray-200 relative">
                    @if($room->foto_kamar)
                        <img src="{{ asset('storage/' . $room->foto_kamar) }}" alt="{{ $room->nomor_kamar }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-sm">
                        {{ $room->tipe->nama_tipe }}
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-8 bg-gray-100/50 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Kamar {{ $room->nomor_kamar }}</h3>
                    <p class="text-gray-500 text-sm line-clamp-2 mb-6 flex-grow">
                        {{ $room->deskripsi }}
                    </p>
                    
                    <div class="flex flex-col gap-1 mb-6">
                        <span class="text-xs font-semibold text-yellow-600 uppercase tracking-wider">Price</span>
                        <span class="text-xl font-bold text-gray-900">Rp {{ number_format($room->tipe->harga_dasar, 0, ',', '.') }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-auto">
                        <a href="{{ route('member.kamar.show', $room) }}" class="px-4 py-3 text-center text-sm font-semibold text-gray-700 border border-gray-300 rounded-xl hover:bg-white hover:border-gray-400 transition">
                            Detail
                        </a>
                        <a href="{{ route('member.kamar.show', $room) }}" class="px-4 py-3 text-center text-sm font-semibold text-white bg-yellow-500 rounded-xl hover:bg-yellow-600 transition shadow-md shadow-yellow-200">
                            Booking Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <hr class="max-w-7xl mx-auto border-gray-200 my-8">

    {{-- Testimonials Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gray-50">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">What Our Guests Say</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Read testimonials from our satisfied guests who have experienced the luxury and comfort of Royal Heaven Hotel.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($recent_reviews as $review)
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
                <p class="text-gray-700 mb-4 italic">"{{ Str::limit($review->komentar, 120) }}"</p>
                <div class="font-semibold text-gray-900">{{ $review->user->name }}</div>
                <div class="text-sm text-gray-600">{{ $review->kamar->nomor_kamar }} - {{ $review->kamar->tipe->nama_tipe }}</div>
                <div class="text-xs text-gray-500 mt-1">{{ $review->created_at ? \Carbon\Carbon::parse($review->created_at)->diffForHumans() : 'N/A' }}</div>
            </div>
            @empty
            <div class="col-span-3 text-center py-8">
                <div class="text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="text-lg font-medium">No reviews yet</p>
                    <p class="text-sm">Be the first to share your experience!</p>
                </div>
            </div>
            @endforelse
        </div>
    </section>

    <hr class="max-w-7xl mx-auto border-gray-200 my-8">

    {{-- Services & Facilities Section --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-serif font-bold text-gray-900 mb-4">Our Premium Services</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Experience world-class hospitality with our comprehensive range of services and facilities designed for your comfort.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3v4a1 1 0 001 1h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">24/7 Concierge</h3>
                <p class="text-gray-600 text-sm">Round-the-clock assistance for all your needs and requests.</p>
            </div>

            <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Spa & Wellness</h3>
                <p class="text-gray-600 text-sm">Relax and rejuvenate with our premium spa treatments and wellness facilities.</p>
            </div>

            <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Fine Dining</h3>
                <p class="text-gray-600 text-sm">Savor exquisite cuisine prepared by world-class chefs in elegant settings.</p>
            </div>

            <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Event Hosting</h3>
                <p class="text-gray-600 text-sm">Host memorable events and celebrations in our versatile event spaces.</p>
            </div>
        </div>
    </section>

    <hr class="max-w-7xl mx-auto border-gray-200 my-8">

    {{-- Call to Action Section --}}
    <section class="bg-gradient-to-r from-yellow-500 to-yellow-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-serif font-bold text-white mb-4">Ready to Experience Luxury?</h2>
            <p class="text-yellow-100 text-lg mb-8 max-w-2xl mx-auto">Book your stay at Royal Heaven Hotel today and discover why we're the preferred choice for discerning travelers worldwide.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('daftarkamar') }}" class="inline-flex items-center px-8 py-3 bg-white text-yellow-600 font-semibold rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path>
                    </svg>
                    Book Your Room
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-yellow-600 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Contact Us
                </a>
            </div>
        </div>
    </section>

@endsection
