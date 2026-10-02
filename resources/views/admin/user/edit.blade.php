@extends('layouts.admin')

@section('page_title', 'Edit Anggota')
@section('page_subtitle', 'Ubah data anggota')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Edit Anggota</h2>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
                <select id="level" name="level" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="member" @if(old('level', $user->level) == 'member') selected @endif>Member</option>
                    <option value="admin" @if(old('level', $user->level) == 'admin') selected @endif>Admin</option>
                </select>
            </div>

            <div>
                <label for="nohp" class="block text-sm font-medium text-gray-700">No. HP</label>
                <input type="text" id="nohp" name="nohp" value="{{ old('nohp', $user->nohp) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" id="nik" name="nik" value="{{ old('nik', $user->nik) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" class="mt-1 w-full border-gray-300 rounded-md shadow-sm px-3 py-2 border focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                    Perbarui
                </button>
                <a href="{{ route('admin.user.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
