@extends('layouts.app')

@section('page_title', 'Form Pemesanan Kamar')
@include('components.hero-section')
@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Pemesanan Kamar</h1>
                <p class="text-gray-600">Isi form di bawah untuk melakukan pemesanan kamar</p>
            </div>

            @if(!empty($noRoomsAvailable))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    Tidak ada kamar yang tersedia untuk dipesan saat ini.
                </div>
            @endif

            <form action="{{ route('member.pemesanan.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilih Kamar -->
                <div class="border-t border-b border-gray-200 py-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Pilih Kamar</h2>
                    
                    <div>
                        <label for="id_kamar" class="block text-sm font-medium text-gray-700 mb-2">
                            Kamar yang Diinginkan
                        </label>
                        <select 
                            id="id_kamar" 
                            name="id_kamar" 
                            required
                            onchange="updateRoomPrice()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('id_kamar') border-red-500 @enderror"
                            @if(!empty($noRoomsAvailable)) disabled @endif
                        >
                            <option value="">-- Pilih Kamar --</option>
                            @foreach($kamars as $kamar)
                                <option 
                                    value="{{ $kamar->id_kamar }}" 
                                    data-price="{{ $kamar->tipe->harga_dasar ?? 0 }}"
                                    @selected(old('id_kamar', $selectedKamarId) == $kamar->id_kamar)
                                >
                                    Kamar {{ $kamar->nomor_kamar }} - {{ $kamar->tipe->nama_tipe }} (Rp {{ number_format($kamar->tipe->harga_dasar ?? 0, 0, ',', '.') }}/malam)
                                </option>
                            @endforeach
                        </select>
                        @error('id_kamar')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tanggal Check-in & Check-out -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800">Tanggal Penginap</h2>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="tgl_check_in" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Check-in
                            </label>
                            <input 
                                type="date" 
                                id="tgl_check_in" 
                                name="tgl_check_in" 
                                required
                                onchange="calculateDays()"
                                value="{{ old('tgl_check_in') }}"
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('tgl_check_in') border-red-500 @enderror"
                                @if(!empty($noRoomsAvailable)) disabled @endif
                            >
                            @error('tgl_check_in')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tgl_check_out" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Check-out
                            </label>
                            <input 
                                type="date" 
                                id="tgl_check_out" 
                                name="tgl_check_out" 
                                required
                                onchange="calculateDays()"
                                value="{{ old('tgl_check_out') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('tgl_check_out') border-red-500 @enderror"
                                @if(!empty($noRoomsAvailable)) disabled @endif
                            >
                            @error('tgl_check_out')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-gray-700"><strong>Total Malam:</strong> <span id="total-malam">0</span> malam</p>
                        <p class="text-sm text-gray-700 mt-1"><strong>Total Harga:</strong> Rp <span id="total-harga">0</span></p>
                    </div>
                </div>

                <!-- Data Pribadi -->
                <div class="border-t border-b border-gray-200 py-6 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800">Data Pemesan</h2>
                    
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap *
                        </label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            required
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('nama', auth()->user()->name) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('nama') border-red-500 @enderror"
                            @if(!empty($noRoomsAvailable)) disabled @endif
                        >
                        @error('nama')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                            NIK (Nomor Identitas) *
                        </label>
                        <input 
                            type="text" 
                            id="nik" 
                            name="nik" 
                            required
                            maxlength="20"
                            placeholder="Masukkan nomor identitas (KTP/Paspor)"
                            value="{{ old('nik', auth()->user()->nik) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('nik') border-red-500 @enderror"
                            @if(!empty($noRoomsAvailable)) disabled @endif
                        >
                        @error('nik')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nohp" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon *
                        </label>
                        <input 
                            type="tel" 
                            id="nohp" 
                            name="nohp" 
                            required
                            maxlength="15"
                            placeholder="Masukkan nomor telepon aktif"
                            value="{{ old('nohp', auth()->user()->nohp) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('nohp') border-red-500 @enderror"
                            @if(!empty($noRoomsAvailable)) disabled @endif
                        >
                        @error('nohp')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Metode Pembayaran & Catatan -->
                <div class="space-y-4">
                    <div>
                        <label for="pilihan_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Metode Pembayaran *
                        </label>
                        <select 
                            id="pilihan_pembayaran" 
                            name="pilihan_pembayaran" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('pilihan_pembayaran') border-red-500 @enderror"
                            @if(!empty($noRoomsAvailable)) disabled @endif
                        >
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            <option value="cash" @selected(old('pilihan_pembayaran') == 'cash')>Tunai</option>
                            <option value="transfer" @selected(old('pilihan_pembayaran') == 'transfer')>Transfer Bank</option>
                            <option value="kartu_kredit" @selected(old('pilihan_pembayaran') == 'kartu_kredit')>Kartu Kredit</option>
                        </select>
                        @error('pilihan_pembayaran')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Khusus
                        </label>
                        <textarea 
                            id="catatan" 
                            name="catatan" 
                            placeholder="Tulis catatan khusus jika ada (misalnya kebutuhan khusus, permintaan kamar)"
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('catatan') border-red-500 @enderror"
                            @if(!empty($noRoomsAvailable)) disabled @endif
                        >{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200"
                        @if(!empty($noRoomsAvailable)) disabled @endif
                    >
                        Lanjutkan Pemesanan
                    </button>
                    <a 
                        href="{{ route('member.index') }}" 
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 px-4 rounded-lg transition-colors duration-200 text-center"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculateDays() {
            const checkIn = document.getElementById('tgl_check_in').value;
            const checkOut = document.getElementById('tgl_check_out').value;
            
            if (checkIn && checkOut) {
                const checkInDate = new Date(checkIn);
                const checkOutDate = new Date(checkOut);
                const days = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
                
                document.getElementById('total-malam').textContent = Math.max(1, days);
                updatePrice();
            }
        }

        function updateRoomPrice() {
            updatePrice();
        }

        function updatePrice() {
            const kamarSelect = document.getElementById('id_kamar');
            const selectedOption = kamarSelect.options[kamarSelect.selectedIndex];
            const pricePerNight = parseInt(selectedOption.dataset.price) || 0;
            const days = parseInt(document.getElementById('total-malam').textContent) || 0;
            const total = pricePerNight * days;
            
            document.getElementById('total-harga').textContent = total.toLocaleString('id-ID');
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateDays();
        });
    </script>
@endsection
X