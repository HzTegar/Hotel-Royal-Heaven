@extends('layouts.admin')

@section('page_title', 'Detail Anggota')
@section('page_subtitle', 'Lihat detail informasi anggota')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Detail Anggota</h2>
            <a href="{{ route('admin.user.index') }}" class="text-blue-500 hover:underline">← Kembali</a>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <p class="mt-1 text-lg text-gray-900">{{ $user->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-lg text-gray-900">{{ $user->email }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <p class="mt-1">
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        @if($user->role == 'admin') bg-red-100 text-red-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">No. HP</label>
                <p class="mt-1 text-lg text-gray-900">{{ $user->nohp ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <p class="mt-1 text-lg text-gray-900">{{ $user->nik ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Alamat</label>
                <p class="mt-1 text-lg text-gray-900">{{ $user->alamat ?? '-' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Terdaftar Sejak</label>
                <p class="mt-1 text-lg text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</p>
            </div>

            <div class="flex space-x-4 pt-6">
                <a href="{{ route('admin.user.edit', $user->id) }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                    Edit
                </a>
                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition">
                        Hapus
                    </button>
                </form>
                <a href="{{ route('admin.user.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition">
                    Batal
                </a>
            </div>
        </div>
    </div>
@endsection
