@extends('layouts.app')

@section('page_title', 'Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-6">Profil Saya</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Informasi Pribadi -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold mb-4">Informasi Pribadi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->nama_lengkap ?: 'Belum diisi' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->username }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->nohp ?: 'Belum diisi' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <p class="mt-1 text-sm text-gray-900">{{ $user->nik ?: 'Belum diisi' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($user->role) }}</p>
            </div>
        </div>
    </div>

    <hr class="my-6">

    <!-- Form Edit Profil -->
    <div>
        <h3 class="text-lg font-semibold mb-4">Edit Profil</h3>

    <form method="POST" action="{{ route('member.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_lengkap" class="block mb-1 font-semibold">Nama Lengkap</label>
            <input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 @error('nama_lengkap') border-red-500 @enderror" required>
            @error('nama_lengkap')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="username" class="block mb-1 font-semibold">Username</label>
            <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 @error('username') border-red-500 @enderror" required>
            @error('username')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-1 font-semibold">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 @error('email') border-red-500 @enderror" required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-1 font-semibold">Password (kosongkan jika tidak ingin diganti)</label>
            <input id="password" name="password" type="password"
                   class="w-full border border-gray-300 rounded px-3 py-2 @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block mb-1 font-semibold">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
