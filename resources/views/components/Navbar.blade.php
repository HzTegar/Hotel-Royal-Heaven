<header class="fixed top-0 left-0 right-0 z-50 w-full transition-all duration-500 pointer-events-none py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pointer-events-auto">
        <div class="flex items-start justify-between gap-4">
            {{-- 1. LOGO SECTION (Left) --}}
            <div class="relative z-50 transition-all duration-500 ease-in-out transform origin-top-left shrink-0 scale-100 translate-y-0">
                <div class="bg-white rounded-b-[2.5rem] px-8 pb-6 pt-4 shadow-2xl flex flex-col items-center justify-center border-t-0 relative overflow-hidden group">
                    {{-- Decorative top line --}}
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-yellow-400 to-yellow-600"></div>

                    <a href="{{ route('landing') }}" class="flex flex-col items-center gap-2">
                        <img src="{{ asset('user/logowebsite.png') }}" alt="Royal Heaven"
                             class="h-16 w-auto object-contain transition-transform duration-500 group-hover:scale-105">
                        <div class="text-center">
                            <h1 class="text-sm font-serif font-bold text-gray-800 tracking-widest uppercase">Royal Heaven</h1>
                            <p class="text-[0.6rem] text-yellow-600 tracking-wider uppercase font-medium">Luxury Hotel</p>
                        </div>
                    </a>
                </div>
            </div>
            

            {{-- Mobile Menu Button --}}
            <div class="md:hidden pt-2 relative z-[60]">
                <button class="mobile-menu-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            {{-- 2. NAVIGATION SECTION (Center) --}}
            <div class="hidden md:block transition-all duration-500">
                 <nav class="bg-white rounded-full shadow-xl px-2 py-3 flex items-center gap-1 transition-all duration-500 border border-gray-100">
                    <div class="flex items-center px-4 gap-1">
                        <a href="{{ route('landing') }}"
                           class="px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-300 relative overflow-hidden group {{ request()->routeIs('landing') || request()->routeIs('home') ? 'text-yellow-600 bg-yellow-50 font-bold' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
                            Dashboard
                        </a>

                        <a href="{{ auth()->check() ? route('member.kamar.index') : route('daftarkamar') }}"
                           class="px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-300 {{ request()->routeIs('member.kamar*') || request()->routeIs('daftarkamar*') ? 'text-yellow-600 bg-yellow-50 font-bold' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
                            Daftar Kamar
                        </a>

                        <a href="{{ route('about') }}"
                           class="px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-300 {{ request()->routeIs('about') ? 'text-yellow-600 bg-yellow-50 font-bold' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
                            About Us
                        </a>
                    </div>
                </nav>
            </div>

            {{-- 3. AUTH SECTION (Right) --}}
            <div class="hidden md:block transition-all duration-500">
                <div class="bg-white rounded-full shadow-xl px-2 py-3 flex items-center gap-2 transition-all duration-500 border border-gray-100">

                    @if(auth()->check())
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('member.profile') }}"
                               class="px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-300 {{ request()->routeIs('member.profile') ? 'text-yellow-600 bg-yellow-50 font-bold' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
                                Profile
                            </a>
                            <a href="{{ route('member.pemesanan.my') }}"
                               class="px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-300 {{ request()->routeIs('member.pemesanan.my') ? 'text-yellow-600 bg-yellow-50 font-bold' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
                                Riwayat
                            </a>

                            <a href="{{ route('member.wishlist.index') }}"
                               class="px-5 py-2.5 text-sm font-medium rounded-full transition-all duration-300 {{ request()->routeIs('member.wishlist*') ? 'text-yellow-600 bg-yellow-50 font-bold' : 'text-gray-600 hover:text-yellow-600 hover:bg-gray-50' }}">
                                <svg class="w-6 h-6 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                                @csrf
                                <button type="submit" class="w-10 h-10 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all duration-300" title="Logout">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('admin.dashboard.index') }}" class="px-5 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 rounded-full transition-all">
                                Admin Panel
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 text-sm font-bold text-gray-700 hover:text-yellow-600 transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-yellow-500 rounded-full hover:bg-yellow-600 transition-all shadow-lg shadow-yellow-500/30 hover:shadow-yellow-500/50 transform hover:-translate-y-0.5">
                            Sign Up
                        </a>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Mobile Menu --}}
    <div class="mobile-menu">
        <nav class="flex flex-col gap-4">
            <a href="{{ route('landing') }}" class="text-lg font-medium text-gray-800 hover:text-yellow-600 transition-colors {{ request()->routeIs('landing') || request()->routeIs('home') ? 'text-yellow-600' : '' }}">
                Dashboard
            </a>
            <a href="{{ auth()->check() ? route('member.kamar.index') : route('daftarkamar') }}" class="text-lg font-medium text-gray-800 hover:text-yellow-600 transition-colors {{ request()->routeIs('member.kamar*') || request()->routeIs('daftarkamar*') ? 'text-yellow-600' : '' }}">
                Daftar Kamar
            </a>
            <a href="{{ route('about') }}" class="text-lg font-medium text-gray-800 hover:text-yellow-600 transition-colors {{ request()->routeIs('about') ? 'text-yellow-600' : '' }}">
                About Us
            </a>

            @if(auth()->check())
                @if(!auth()->user()->isAdmin())
                    <hr class="border-gray-200 my-4">
                    <a href="{{ route('member.profile') }}" class="text-lg font-medium text-gray-800 hover:text-yellow-600 transition-colors {{ request()->routeIs('member.profile') ? 'text-yellow-600' : '' }}">
                        Profile
                    </a>
                    <a href="{{ route('member.pemesanan.my') }}" class="text-lg font-medium text-gray-800 hover:text-yellow-600 transition-colors {{ request()->routeIs('member.pemesanan.my') ? 'text-yellow-600' : '' }}">
                        Riwayat
                    </a>
                    <a href="{{ route('member.wishlist.index') }}" class="text-lg font-medium text-gray-800 hover:text-yellow-600 transition-colors {{ request()->routeIs('member.wishlist*') ? 'text-yellow-600' : '' }}">
                        Wishlist
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 text-white py-3 px-4 rounded-lg hover:bg-red-600 transition-colors">
                            Logout
                        </button>
                    </form>
                @else
                    <hr class="border-gray-200 my-4">
                    <a href="{{ route('admin.dashboard.index') }}" class="text-lg font-medium text-red-600 hover:text-red-700 transition-colors">
                        Admin Panel
                    </a>
                @endif
            @else
                <hr class="border-gray-200 my-4">
                <a href="{{ route('login') }}" class="text-lg font-medium text-gray-800 hover:text-yellow-600 transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}" class="bg-yellow-500 text-white py-3 px-4 rounded-lg hover:bg-yellow-600 transition-colors text-center block">
                    Sign Up
                </a>
            @endif
        </nav>
    </div>
</header>
