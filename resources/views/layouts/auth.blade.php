<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Royal Heaven') }}</title>
    {{-- Prefer Vite during development, fallback to built CSS, then CDN fallback --}}
    @if (function_exists('vite'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @elseif (file_exists(public_path('css/app.css')))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @else
        {{-- Tailwind CDN fallback for quick styling when assets are not built --}}
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <style>
            /* minimal fallback to keep layout readable */
            .auth-bg { background: #444; color: #fff; }
            .card-shadow { box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
        </style>
    @endif
    <style>
        .auth-bg {
            background: linear-gradient(90deg, rgba(22,22,22,0.55), rgba(22,22,22,0.55)), url('/images/hotel-bg.jpg');
            background-size: cover;
            background-position: center;
        }
        .card-shadow { box-shadow: 0 10px 30px rgba(0,0,0,0.12); }
    </style>
</head>
<body class="min-h-screen bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        @yield('content')
    </div>
</body>
</html>
