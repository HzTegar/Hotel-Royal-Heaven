@extends('layouts.admin')

@section('page_title', 'Manajemen Kamar')
@section('page_subtitle', 'Kelola semua kamar di hotel Royal Heaven')

@section('content')
    <section class="w-full max-w-7xl mx-auto py-12 px-6">
        <div class="flex flex-col gap-12">
            <!-- Card: Manajemen Kamar -->
            <div class="bg-white rounded-xl shadow-lg p-6 relative">
                <a href="{{ route('admin.kamar.create') }}" class="absolute right-6 top-6 inline-flex items-center gap-2 bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md shadow transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"></path></svg>
                    Add DataKamar
                </a>
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Manajemen Kamar</h2>

                {{-- Filter and Search --}}
                <div class="mb-6">
                    <form method="GET" action="{{ route('admin.kamar.index') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <input type="text" name="nomor_kamar" placeholder="Cari nomor kamar..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" value="{{ request('nomor_kamar') }}">
                            <select name="type" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="">-- Semua Tipe --</option>
                                @foreach($tipeKamars as $tipe)
                                    <option value="{{ $tipe->nama_tipe }}" @selected(request('type') == $tipe->nama_tipe)>{{ $tipe->nama_tipe }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="">-- Semua Status --</option>
                                <option value="available" @selected(request('status') == 'available')>Tersedia</option>
                                <option value="booked" @selected(request('status') == 'booked')>Dipesan</option>
                                <option value="maintenance" @selected(request('status') == 'maintenance')>Pemeliharaan</option>
                            </select>
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">Filter</button>
                                <a href="{{ route('admin.kamar.index') }}" class="w-full text-center px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="min-h-[200px] bg-gray-50 rounded-md p-4">
                    @if($kamars->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Kamar</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Kamar</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto Utama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto Detail</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($kamars as $index => $kamar)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ ($kamars->currentPage() - 1) * $kamars->perPage() + $index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-900">
                                                {{ $kamar->nomor_kamar }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $kamar->tipe->nama_tipe ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-semibold">
                                                Rp{{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                    @if($kamar->status_ketersediaan == 'available') bg-green-100 text-green-800
                                                    @elseif($kamar->status_ketersediaan == 'booked') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    @if($kamar->status_ketersediaan == 'available') Tersedia
                                                    @elseif($kamar->status_ketersediaan == 'booked') Dipesan
                                                    @else Pemeliharaan @endif
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($kamar->foto_kamar)
                                                    <img src="{{ asset('storage/' . $kamar->foto_kamar) }}" alt="Foto Utama" class="w-16 h-16 object-cover rounded-lg border">
                                                @else
                                                    <span class="text-gray-400 text-xs">Tidak ada foto</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 max-w-xs">
                                                @if($kamar->foto_detail)
                                                    @php
                                                        $detailPhotos = json_decode($kamar->foto_detail, true);
                                                    @endphp
                                                    @if(is_array($detailPhotos) && count($detailPhotos) > 0)
                                                        <div class="flex flex-wrap gap-1">
                                                            @foreach(array_slice($detailPhotos, 0, 3) as $photo)
                                                                <img src="{{ asset('storage/' . $photo) }}" alt="Foto Detail" class="w-8 h-8 object-cover rounded border flex-shrink-0">
                                                            @endforeach
                                                            @if(count($detailPhotos) > 3)
                                                                <span class="text-xs text-gray-500 self-center">+{{ count($detailPhotos) - 3 }}</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400 text-xs">Tidak ada foto</span>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400 text-xs">Tidak ada foto</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                                                {{ $kamar->deskripsi ?? '—' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('admin.kamar.edit', $kamar) }}" class="bg-blue-900 hover:bg-blue-800 text-white px-3 py-1 rounded text-xs transition-colors">Edit</a>
                                                    <form method="POST" action="{{ route('admin.kamar.destroy', $kamar) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition-colors">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-6">{{ $kamars->links() }}</div>
                    @else
                        <div class="text-center text-gray-500 py-8">Belum ada data kamar.</div>
                    @endif
                </div>
            </div>


        </div>
    </section>
@endsection