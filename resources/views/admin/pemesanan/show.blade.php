@extends('layouts.admin')

@section('page_title', 'Detail Pemesanan')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Detail Pemesanan #{{ $pemesanan->id }}</h2>
        <a href="{{ route('admin.pemesanan.index') }}" class="text-blue-600 hover:underline">← Kembali ke Daftar</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informasi Pemesanan -->
        <div class="bg-gray-50 p-4 rounded">
            <h3 class="font-semibold mb-3 text-gray-800">Informasi Pemesanan</h3>
            <div class="space-y-2">
                <p><span class="font-medium">ID Pemesanan:</span> #{{ $pemesanan->id }}</p>
                <p><span class="font-medium">Tanggal Pemesanan:</span> {{ $pemesanan->tgl_pemesanan->format('d M Y H:i') }}</p>
                <p><span class="font-medium">Check-in:</span> {{ $pemesanan->check_in->format('d M Y') }}</p>
                <p><span class="font-medium">Check-out:</span> {{ $pemesanan->check_out->format('d M Y') }}</p>
                <p><span class="font-medium">Jumlah Malam:</span> {{ $pemesanan->jumlah_malam }}</p>
                <p><span class="font-medium">Total Harga:</span> Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>
                <p><span class="font-medium">Metode Pembayaran:</span> {{ ucfirst($pemesanan->metode_pembayaran ?? 'N/A') }}</p>
                <p><span class="font-medium">Status:</span>
                    <span class="px-2 py-1 rounded text-sm font-medium
                        @if($pemesanan->status_pemesanan == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($pemesanan->status_pemesanan == 'confirmed') bg-blue-100 text-blue-800
                        @elseif($pemesanan->status_pemesanan == 'cancelled') bg-red-100 text-red-800
                        @elseif($pemesanan->status_pemesanan == 'completed') bg-green-100 text-green-800
                        @endif">
                        {{ ucfirst($pemesanan->status_pemesanan) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Informasi Member -->
        <div class="bg-gray-50 p-4 rounded">
            <h3 class="font-semibold mb-3 text-gray-800">Informasi Member</h3>
            <div class="space-y-2">
                <p><span class="font-medium">Nama Lengkap:</span> {{ $pemesanan->nama_pemesan }}</p>
                <p><span class="font-medium">NIK:</span> {{ $pemesanan->nik }}</p>
                <p><span class="font-medium">No. HP:</span> {{ $pemesanan->nohp }}</p>
                <p><span class="font-medium">Email:</span> {{ $pemesanan->user->email ?? 'N/A' }}</p>
                <p><span class="font-medium">Username:</span> {{ $pemesanan->user->username ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Informasi Kamar -->
        <div class="bg-gray-50 p-4 rounded md:col-span-2">
            <h3 class="font-semibold mb-3 text-gray-800">Informasi Kamar</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p><span class="font-medium">Nomor Kamar:</span> {{ $pemesanan->kamar->nomor_kamar ?? 'N/A' }}</p>
                    <p><span class="font-medium">Tipe Kamar:</span> {{ $pemesanan->kamar->tipeKamar->nama_tipe ?? 'N/A' }}</p>
                </div>
                <div>
                    <p><span class="font-medium">Harga per Malam:</span> Rp {{ number_format($pemesanan->kamar->harga ?? 0, 0, ',', '.') }}</p>
                    <p><span class="font-medium">Status Kamar:</span>
                        <span class="px-2 py-1 rounded text-sm font-medium
                            @if($pemesanan->kamar->status_ketersediaan == 'available') bg-green-100 text-green-800
                            @elseif($pemesanan->kamar->status_ketersediaan == 'occupied') bg-red-100 text-red-800
                            @elseif($pemesanan->kamar->status_ketersediaan == 'maintenance') bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($pemesanan->kamar->status_ketersediaan ?? 'N/A') }}
                        </span>
                    </p>
                </div>
                <div>
                    <p><span class="font-medium">Deskripsi:</span></p>
                    <p class="text-sm text-gray-600">{{ $pemesanan->kamar->tipeKamar->deskripsi ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Catatan Khusus -->
        @if($pemesanan->catatan)
        <div class="bg-gray-50 p-4 rounded md:col-span-2">
            <h3 class="font-semibold mb-3 text-gray-800">Catatan Khusus</h3>
            <p class="text-gray-700">{{ $pemesanan->catatan }}</p>
        </div>
        @endif
    </div>

    <!-- Update Status Form -->
    <div class="mt-6 bg-white border border-gray-200 p-4 rounded">
        <h3 class="font-semibold mb-3 text-gray-800">Update Status Pemesanan</h3>
        <form method="POST" action="{{ route('pemesanan.updateStatus', $pemesanan->id) }}" class="flex items-center space-x-4">
            @csrf
            <div>
                <select name="status_pemesanan" class="border border-gray-300 rounded px-3 py-2">
                    <option value="pending" {{ $pemesanan->status_pemesanan == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $pemesanan->status_pemesanan == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $pemesanan->status_pemesanan == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ $pemesanan->status_pemesanan == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition">
                Update Status
            </button>
        </form>
    </div>
</div>
@endsection
