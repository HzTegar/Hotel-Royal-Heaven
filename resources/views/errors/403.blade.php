@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <h1 class="text-9xl font-bold text-red-500">403</h1>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Akses Ditolak</h2>
            <p class="mt-2 text-sm text-gray-600">
                Anda tidak memiliki izin untuk mengakses halaman ini.
            </p>
        </div>

        <div class="mt-8">
            <a href="{{ route('home') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        @auth
            <div class="mt-6">
                <a href="{{ route('member.dashboard') }}"
                   class="text-sm text-yellow-600 hover:text-yellow-500 transition-colors duration-200">
                    ← Kembali ke Dashboard
                </a>
            </div>
        @endauth

        <div class="mt-6">
            <a href="javascript:history.back()"
               class="text-sm text-gray-600 hover:text-gray-500 transition-colors duration-200">
                ← Kembali ke halaman sebelumnya
            </a>
        </div>
    </div>
</div>
@endsection
