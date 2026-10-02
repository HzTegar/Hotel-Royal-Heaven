@extends('layouts.auth')

@section('content')
    {{-- Prevent browser from caching this page --}}
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <style>
        /* CSS Kustom untuk menampung Gambar Latar Belakang */
        .auth-bg-image {
            /* Ganti 'gambarhotel.jpg' dengan path atau URL gambar yang benar */
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('gambarhotel.jpg');
            background-size: cover;
            background-position: center;
        }

        /* Interactive Styles */
        .floating-logo {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .typing-text {
            border-right: 2px solid #fff;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 50% { border-color: transparent; }
            51%, 100% { border-color: #fff; }
        }

        .stat-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-item:hover {
            transform: scale(1.05);
            color: #fbbf24;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #fbbf24;
        }

        /* Background Particles */
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: drift 20s linear infinite;
        }

        .particle:nth-child(1) { width: 4px; height: 4px; top: 10%; left: 20%; animation-delay: 0s; }
        .particle:nth-child(2) { width: 6px; height: 6px; top: 30%; left: 70%; animation-delay: 5s; }
        .particle:nth-child(3) { width: 3px; height: 3px; top: 50%; left: 10%; animation-delay: 10s; }
        .particle:nth-child(4) { width: 5px; height: 5px; top: 70%; left: 80%; animation-delay: 15s; }
        .particle:nth-child(5) { width: 4px; height: 4px; top: 20%; left: 50%; animation-delay: 20s; }
        .particle:nth-child(6) { width: 3px; height: 3px; top: 60%; left: 30%; animation-delay: 25s; }
        .particle:nth-child(7) { width: 5px; height: 5px; top: 40%; left: 90%; animation-delay: 30s; }
        .particle:nth-child(8) { width: 4px; height: 4px; top: 80%; left: 40%; animation-delay: 35s; }

        @keyframes drift {
            0% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(100px); opacity: 0; }
        }

        /* Parallax effect for background */
        .auth-bg-image {
            transform: translateZ(0);
            will-change: transform;
        }

        /* Body particles behind form */
        body {
            position: relative;
            overflow: hidden;
        }

        .form-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .form-particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: form-float 15s ease-in-out infinite;
        }

        .form-particle:nth-child(1) { width: 8px; height: 8px; top: 20%; right: 10%; animation-delay: 0s; }
        .form-particle:nth-child(2) { width: 6px; height: 6px; top: 40%; right: 20%; animation-delay: 3s; }
        .form-particle:nth-child(3) { width: 4px; height: 4px; top: 60%; right: 15%; animation-delay: 6s; }
        .form-particle:nth-child(4) { width: 10px; height: 10px; top: 30%; right: 25%; animation-delay: 9s; }
        .form-particle:nth-child(5) { width: 5px; height: 5px; top: 50%; right: 5%; animation-delay: 12s; }

        @keyframes form-float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
            50% { transform: translateY(-20px) rotate(180deg); opacity: 0.8; }
        }
    </style>

    <div class="w-full max-w-6xl mx-auto rounded-lg overflow-hidden grid grid-cols-1 md:grid-cols-2 shadow-xl">

        <div class="p-10 bg-white">
            <div class="max-w-md mx-auto">

                <div class="flex items-center justify-center mb-6">
                    <div class="w-16 h-16 rounded-full bg-yellow-400 flex items-center justify-center text-white text-2xl floating-logo">♛</div>
                </div>

                <h3 class="text-center text-3xl font-bold mb-2 text-gray-800">Forgot Password?</h3>
                <p class="text-center text-sm text-gray-500 mb-8">Enter your email address and we'll send you a link to reset your password.</p>

                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="sr-only">Email</label>
                        <input name="email" id="email" type="email" required placeholder="Email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('email') border-red-500 @enderror">
                        @error('email')<span class="text-sm text-red-500 mt-1 block">Incorrect email or password please check and try again.</span>@enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('login') }}" class="text-yellow-500 font-medium hover:text-yellow-600">Back to Login</a>
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg py-3 px-6 font-semibold transition-colors duration-200">Send Reset Link</button>
                    </div>

                </form>
            </div>
        </div>

        <div class="hidden md:block auth-bg-image p-12 text-white">
            <div class="h-full flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-yellow-500 rounded-full"></div>
                        <h1 class="text-xl font-semibold">ROYAL HEAVEN</h1>
                    </div>
                    <h2 class="text-4xl font-extrabold mb-4">Where Luxury Meets Perfection</h2>
                    <p class="text-gray-200 max-w-md">Experience world-class hospitality with our premium services and unmatched comfort.</p>
                </div>

                <div class="flex gap-8 text-sm">
                    <div class="stat-item">
                        <div class="stat-number" data-target="200">0</div>
                        <div class="text-gray-100">Luxury Rooms</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="25">0</div>
                        <div class="text-gray-100">Locations</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-target="24">0</div>
                        <div class="text-gray-100">Concierge</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Typing animation for description
            const description = document.querySelector('.auth-bg-image p');
            if (description) {
                const text = description.textContent;
                description.textContent = '';
                description.classList.add('typing-text');
                let i = 0;
                const timer = setInterval(() => {
                    if (i < text.length) {
                        description.textContent += text.charAt(i);
                        i++;
                    } else {
                        clearInterval(timer);
                        description.classList.remove('typing-text');
                    }
                }, 50);
            }

            // Counting animation for stats
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const increment = target / 100;
                let current = 0;

                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.ceil(current);
                        setTimeout(updateCounter, 20);
                    } else {
                        counter.textContent = target;
                    }
                };

                // Start animation when element is visible
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            updateCounter();
                            observer.unobserve(entry.target);
                        }
                    });
                });
                observer.observe(counter);
            });
        });
    </script>
@endsection
