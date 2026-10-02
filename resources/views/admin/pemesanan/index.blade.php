@extends('layouts.admin')

@section('page_title', 'Manajemen Pemesanan')
@section('page_subtitle', 'Kelola semua pemesanan di hotel Royal Heaven')

@section('content')
<div class="overflow-x-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Daftar Pemesanan</h2>

    {{-- Filter and Search --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('admin.pemesanan.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" placeholder="Cari (Kode, Nama)..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" value="{{ request('search') }}">
                <select name="status" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                    <option value="confirmed" @selected(request('status') == 'confirmed')>Confirmed</option>
                    <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelled</option>
                    <option value="completed" @selected(request('status') == 'completed')>Completed</option>
                </select>
                <input type="date" name="date_from" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" value="{{ request('date_from') }}">
                <div class="flex space-x-2">
                    <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">Filter</button>
                    <a href="{{ route('admin.pemesanan.index') }}" class="w-full text-center px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">Reset</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-yellow-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Pemesan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Kamar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Check-in / Out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pemesanan as $p)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">{{ $p->kode_pemesanan }}</div>
                        <div class="text-xs text-gray-500">{{ $p->tgl_pemesanan->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $p->user->nama_lengkap ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $p->user->email ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $p->kamar->nomor_kamar ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ $p->tgl_check_in ? \Carbon\Carbon::parse($p->tgl_check_in)->format('d M Y') : 'N/A' }} - {{ $p->tgl_check_out ? \Carbon\Carbon::parse($p->tgl_check_out)->format('d M Y') : 'N/A' }}
                        <span class="text-xs">({{ $p->total_malam }} malam)</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @switch($p->status_pemesanan)
                                @case('pending') bg-yellow-100 text-yellow-800 @break
                                @case('confirmed') bg-green-100 text-green-800 @break
                                @case('cancelled') bg-red-100 text-red-800 @break
                                @case('completed') bg-blue-100 text-blue-800 @break
                            @endswitch">
                            {{ ucfirst($p->status_pemesanan) }}
                        </span>
                        <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($p->payment_status == 'paid') bg-green-100 text-green-800 @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($p->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <form action="{{ route('admin.pemesanan.updateStatus', $p) }}" method="POST">
                            @csrf
                            <select name="status_pemesanan" class="text-xs p-1 border rounded" onchange="this.form.submit()">
                                <option value="pending" @selected($p->status_pemesanan == 'pending')>Pending</option>
                                <option value="confirmed" @selected($p->status_pemesanan == 'confirmed')>Confirmed</option>
                                <option value="completed" @selected($p->status_pemesanan == 'completed')>Completed</option>
                                <option value="cancelled" @selected($p->status_pemesanan == 'cancelled')>Cancelled</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <p class="font-semibold">Tidak ada data pemesanan.</p>
                            <p class="text-sm">Data akan muncul di sini setelah ada pemesanan dari member.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $pemesanan->links() }}
    </div>
</div>
@endsection
