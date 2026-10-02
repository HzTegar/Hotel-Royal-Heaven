@extends('layouts.app')
@section('page_title', 'About Us')
@section('content')
    @include('components.hero-about', [
        'title' => 'About Royal Heaven Hotel',
        'subtitle' => 'Discover Our Story',
        'description' => 'Experience unparalleled luxury and hospitality at Royal Heaven Hotel. A place where every moment is crafted for your comfort and satisfaction.',
        'ctaText' => 'Learn More About Us',
        'ctaLink' => '#our-story-section'
    ])
        
        
    

    {{-- OUR STORY SECTION --}}
    <section id="our-story-section" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
                <div class="mb-10 lg:mb-0">
                    <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-yellow-800 uppercase bg-yellow-100 rounded-full mb-4">Our Story</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mb-6">
                        Journey to Excellence
                    </h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Royal Heaven Hotel has become a symbol of unparalleled luxury and hospitality. Starting with a simple vision to create a place where every guest feels special, we have grown to become one of Indonesia's leading hotels.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        With a combination of magnificent classic architecture and the latest modern amenities, we continually innovate to provide the perfect stay experience. Every detail is meticulously designed to ensure maximum comfort and satisfaction.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-100">
                            <h3 class="font-bold text-gray-900 mb-2">Our Vision</h3>
                            <p class="text-sm text-gray-600">To be the preferred hotel offering a world-class accommodation experience.</p>
                        </div>
                        <div class="bg-yellow-50 p-6 rounded-xl border border-yellow-100">
                            <h3 class="font-bold text-gray-900 mb-2">Our Mission</h3>
                            <p class="text-sm text-gray-600">To provide the best service, prioritizing guest satisfaction and comfort.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-w-3 aspect-h-2 rounded-2xl overflow-hidden shadow-2xl">
                        <img class="object-cover w-full h-full" src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Hotel Exterior">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- OUR VALUES SECTION --}}
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wider text-yellow-800 uppercase bg-yellow-100 rounded-full mb-4">Our Values</span>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Our Commitment to Excellence
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Fundamental values that underpin every service and interaction we provide with our guests.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Value 1 -->
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center text-white mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sincere Hospitality</h3>
                    <p class="text-gray-600">
                        We serve with our hearts, ensuring every guest feels welcomed and valued like family.
                    </p>
                </div>

                <!-- Value 2 -->
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center text-white mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Premium Quality</h3>
                    <p class="text-gray-600">
                        The highest standards in facilities, services, and experiences for maximum satisfaction.
                    </p>
                </div>

                <!-- Value 3 -->
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center text-white mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Professional Team</h3>
                    <p class="text-gray-600">
                        Experienced and experienced staff ready to provide the best service 24/7.
                    </p>
                </div>

                <!-- Value 4 -->
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center text-white mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Service Excellence</h3>
                    <p class="text-gray-600">
                        Commitment to exceeding expectations and creating unforgettable moments.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA SECTION --}}
    <section class="py-20 bg-yellow-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-6">
                Ready for a special stay?
            </h2>
            <p class="text-xl text-yellow-100 mb-10 max-w-2xl mx-auto">
                Join thousands of guests who have trusted us to create unforgettable moments.
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('daftarkamar') }}" class="px-8 py-3 bg-white text-yellow-700 font-bold rounded-full hover:bg-gray-100 transition shadow-lg">
                    View Available Rooms
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-3 bg-yellow-700 text-white font-bold rounded-full hover:bg-yellow-800 transition shadow-lg border border-yellow-500">
                    Contact Us
                </a>
            </div>
        </div>
    </section>
@endsection
