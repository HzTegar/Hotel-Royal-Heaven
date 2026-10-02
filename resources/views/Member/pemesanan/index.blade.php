@extends('layouts.admin')

@section('page_title', 'Manajemen Pemesanan')
@section('page_subtitle', 'Kelola semua pemesanan kamar hotel')

@section('content')
    <div class="space-y-6">
        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Cari Pemesanan</h2>
            
            <form method="GET" action="{{ route('member.pemesanan.my') }}" class="flex gap-3">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari berdasarkan kode, nama, atau kamar..." 
                    value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                >
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                    Cari
                </button>
                <a href="{{ route('member.pemesanan.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg transition-colors">
                    Reset
                </a>
            </form>
        </div>

        <!-- Pemesanan Table -->
        @if($pemesanan->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Pemesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kamar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Check-in</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Check-out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pemesanan as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $p->kode_pemesanan }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="font-medium">{{ $p->user->nama_lengkap ?? $p->user->username }}</div>
                                        <div class="text-xs text-gray-400">{{ $p->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Kamar {{ $p->kamar->nomor_kamar ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($p->tgl_check_in)
                                            {{ $p->tgl_check_in ? \Carbon\Carbon::parse($p->tgl_check_in)->format('d M Y') : 'N/A' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($p->tgl_check_out)
                                            {{ $p->tgl_check_out ? \Carbon\Carbon::parse($p->tgl_check_out)->format('d M Y') : 'N/A' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-yellow-600">
                                        Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @php
                                            $status = strtolower($p->status_pemesanan);
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                            if (strpos($status, 'pending') !== false) {
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                            } elseif (strpos($status, 'confirmed') !== false || strpos($status, 'completed') !== false) {
                                                $statusClass = 'bg-green-100 text-green-800';
                                            } elseif (strpos($status, 'cancelled') !== false) {
                                                $statusClass = 'bg-red-100 text-red-800';
                                            }
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst($p->status_pemesanan) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('member.pemesanan.show', $p) }}" class="text-blue-600 hover:text-blue-900">
                                            Lihat
                                        </a>
                                        
                                        @if($p->status_pemesanan != 'cancelled' && $p->status_pemesanan != 'completed')
                                            <form method="POST" action="{{ route('admin.pemesanan.updateStatus', $p) }}" class="inline">
                                                @csrf
                                                <select 
                                                    name="status_pemesanan" 
                                                    onchange="this.form.submit()"
                                                    class="text-xs px-2 py-1 border border-gray-300 rounded bg-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                                >
                                                    <option value="">-- Ubah Status --</option>
                                                    <option value="pending" @selected($p->status_pemesanan == 'pending')>Pending</option>
                                                    <option value="confirmed" @selected($p->status_pemesanan == 'confirmed')>Confirmed</option>
                                                    <option value="cancelled">Cancelled</option>
                                                    <option value="completed" @selected($p->status_pemesanan == 'completed')>Completed</option>
                                                </select>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $pemesanan->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-8a1 1 0 112 0v3a1 1 0 11-2 0v-3z" clip-rule="evenodd"></path></svg>
                <p class="text-gray-500 text-lg">Belum ada pemesanan</p>
            </div>
        @endif
    </div>
@endsection
