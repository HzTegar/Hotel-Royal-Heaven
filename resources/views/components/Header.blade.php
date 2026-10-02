<header class="fixed top-0 left-0 right-0 z-40 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-start justify-between h-20">
            
            {{-- LOGO BARU DAN KARTU --}}
            <div class="relative mt-0 ml-[-20px] md:ml-[-40px] z-50">
                <div class="bg-white rounded-bl-3xl rounded-br-1xl p-4 md:p-6 shadow-lg 
                            flex flex-col items-center justify-center text-center"
                     style="
                         clip-path: polygon(0% 0%, 100% 0%, 100% 85%, 0% 100%); 
                         width: 180px; 
                         height: auto;
                     ">
                    
                    {{-- Konten Logo (Tidak berubah) --}}
                    <img src="{{ asset('user/logowebsite.png') }}" alt="Crown Logo" class="h-20 w-auto mb-2">
                    
                    <div class="mt-4">
                        <span class="text-base font-semibold text-gray-800 block">Royal Heaven</span>
                        <span class="text-xs text-gray-500 block tracking-wider">Luxury Hotel</span>
                    </div>
                </div>
                
                {{-- Efek Bayangan Diagonal di Bawah --}}
                <div class="absolute inset-0 z-[-1] rounded-bl-3xl rounded-tl-xl rounded-tr-xl rounded-br-none" 
                    style="
                        transform: translate(10px, 10px); 
                        background-color: rgba(0,0,0,0.1); 
                        /* PENTING: clip-path yang sama dengan kartu utama */
                        clip-path: polygon(0% 0%, 100% 0%, 100% 85%, 0% 100%);
                    ">
                </div>
            </div>
            {{-- AKHIR LOGO BARU --}}
            
        </div>

        <div class="relative z-50 flex justify-center w-full" style="margin-top: -60px;">
            <nav class="w-full max-w-3xl">
                <div class="flex gap-x-4 lg:gap-x-6 bg-white rounded-xl py-2 px-4 shadow-xl border-t-2 border-b-2 border-transparent justify-center"
                     style="box-shadow: 0 4px 24px 0 rgba(0,0,0,0.08);">
    
    {{-- Navigation untuk Guest (Belum Login) --}}
    <a href="{{ route('landing') }}" class="px-4 py-2 transition duration-150 text-center 
        {{ request()->routeIs('landing') ? 'font-semibold text-yellow-600 border-b-4 border-yellow-500' : 'font-medium text-gray-900 hover:text-yellow-600' }}">
        Home
    </a>
    <a href="{{ route('daftarkamar') }}" class="px-4 py-2 transition duration-150 text-center
        {{ request()->routeIs('daftarkamar') ? 'font-semibold text-yellow-600 border-b-4 border-yellow-500' : 'font-medium text-gray-900 hover:text-yellow-600' }}">
        Daftar Kamar
    </a>
    <a href="{{ route('landing') }}#about" class="px-4 py-2 font-medium text-gray-900 hover:text-yellow-600 transition duration-150 text-center">
        About Us
    </a>
    <a href="{{ route('login') }}" class="px-4 py-2 transition duration-150 text-center 
        {{ request()->routeIs('login') ? 'font-semibold text-yellow-600 border-b-4 border-yellow-500' : 'font-medium text-gray-900 hover:text-yellow-600' }}">
        Login
    </a>
                </div>
            </nav>
        </div>
    </div>
</header>