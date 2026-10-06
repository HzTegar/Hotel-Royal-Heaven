<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Hotel Royal Heaven')</title>

   <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <style>
        .navbar {
            background-color: #ffb833;
        }
        .logo {
            font-weight: bold;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .nav-link {
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #1f2937;
        }

        /* Interactive Features Styles */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .animate-on-scroll.animate-in {
            opacity: 1;
            transform: translateY(0);
        }

        .navbar-shrink {
            transform: scale(0.95);
            opacity: 0.9;
        }

        .navbar-hidden {
            transform: translateY(-100%);
        }

        /* Mobile Menu Styles */
        .mobile-menu-btn {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            width: 30px;
            height: 30px;
            background: white;
            border: none;
            border-radius: 8px;
            padding: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .mobile-menu-btn span {
            width: 100%;
            height: 3px;
            background: #374151;
            border-radius: 2px;
            transition: all 0.3s ease;
            transform-origin: center;
        }

        .mobile-menu-btn.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .mobile-menu-btn.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        .mobile-menu-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-menu-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 85%;
            max-width: 400px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
            box-shadow: -10px 0 30px rgba(0,0,0,0.1);
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu nav {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        /* Notification Styles */
        .notification {
            position: fixed;
            top: 20px;
            right: -400px;
            width: 300px;
            max-width: 90vw;
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 10000;
            transition: all 0.3s ease;
            border-left: 4px solid #10b981;
        }

        .notification.notification-error {
            border-left-color: #ef4444;
        }

        .notification.notification-warning {
            border-left-color: #f59e0b;
        }

        .notification.notification-info {
            border-left-color: #3b82f6;
        }

        .notification.show {
            right: 20px;
        }

        .notification-content {
            padding: 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .notification-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #6b7280;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Lightbox Styles */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .lightbox.active {
            opacity: 1;
            visibility: visible;
        }

        .lightbox-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }

        .lightbox-content {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
            z-index: 1;
        }

        .lightbox-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .lightbox-close,
        .lightbox-prev,
        .lightbox-next {
            position: absolute;
            background: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .lightbox-close {
            top: -20px;
            right: -20px;
            font-size: 24px;
            color: #374151;
        }

        .lightbox-prev {
            left: -60px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #374151;
        }

        .lightbox-next {
            right: -60px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #374151;
        }

        /* Form Enhancements */
        .field-error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        input.valid {
            border-color: #10b981;
            box-shadow: 0 0 0 1px #10b981;
        }

        input.invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 1px #ef4444;
        }

        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Ripple Effect */
        .ripple-btn {
            position: relative;
            overflow: hidden;
        }

        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Parallax Elements */
        .parallax {
            will-change: transform;
        }

        /* Typing Animation */
        .typing-text {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
        }

        /* Lazy Loading */
        img.lazy {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        img.lazy[src] {
            opacity: 1;
        }

        /* Image Gallery */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .image-gallery img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .image-gallery img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Hero Logo & Navbar -->
    @if(!isset($hideNavbar) || !$hideNavbar)
    <div class="relative">
        @include('components.Navbar')
    </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-full ">
        @yield('content')
    </main>

    <!-- Floating Contact Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="{{ route('contact') }}"
           class="w-16 h-16 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
        </a>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">♛</div>
                        Royal Heaven Hotel
                    </h3>
                    <p class="text-gray-400">Sistem manajemen pemesanan kamar hotel terpercaya dengan layanan terbaik.</p>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('daftarkamar') }}" class="hover:text-yellow-400 transition">Daftar Kamar</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-yellow-400 transition">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-yellow-400 transition">Contact</a></li>
                        @if(Auth::check())
                            <li><a href="{{ route('member.pemesanan.my') }}" class="hover:text-yellow-400 transition">Pemesanan Saya</a></li>
                        @endif
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Telepon: +62 812-3945-0638</li>
                        <li>Email: muhammadarkanfauzi@gmail.com</li>
                        <li>Alamat: Jl. Raya Bogor KM 47, Cibinong, Bogor<br>Jawa Barat 16911, Indonesia</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Royal Heaven Hotel. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const mobileMenu = document.querySelector('.mobile-menu');
            const mobileMenuBackdrop = document.querySelector('.mobile-menu-backdrop');
            const mobileMenuClose = document.querySelector('.mobile-menu-close');

            function toggleMenu() {
                if (mobileMenuBtn) mobileMenuBtn.classList.toggle('active');
                if (mobileMenu) mobileMenu.classList.toggle('active');
                if (mobileMenuBackdrop) mobileMenuBackdrop.classList.toggle('active');
                document.body.classList.toggle('overflow-hidden');
            }

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', toggleMenu);
            }

            if (mobileMenuBackdrop) {
                mobileMenuBackdrop.addEventListener('click', toggleMenu);
            }

            if (mobileMenuClose) {
                mobileMenuClose.addEventListener('click', toggleMenu);
            }
        });
    </script>
</body>
</html>
