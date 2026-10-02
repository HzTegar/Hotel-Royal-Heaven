@extends('layouts.admin')

@section('page_title', 'Profil Admin')
@section('page_subtitle', 'Lihat dan kelola profil admin')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Profil Admin</h2>

        <div class="space-y-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <p class="mt-1 text-gray-900">{{ $user->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <p class="mt-1 text-gray-900">{{ $user->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">No. HP</label>
                <p class="mt-1 text-gray-900">{{ $user->nohp ?? '-' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <p class="mt-1 text-gray-900">{{ ucfirst($user->role) }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tanggal Bergabung</label>
                <p class="mt-1 text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('admin.profile.edit') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Edit Profil
            </a>
            <a href="{{ route('admin.dashboard.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                Kembali
            </a>
        </div>
    </div>
@endsection
