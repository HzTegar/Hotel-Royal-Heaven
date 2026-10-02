<div class="bg-white rounded-lg shadow-md p-8 mb-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pemesanan Kamar</h1>
        <p class="text-gray-600">Isi form di bawah untuk melakukan pemesanan kamar</p>
    </div>

    @if($kamars->isEmpty())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            Tidak ada kamar yang tersedia untuk dipesan saat ini.
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- Pilih Kamar -->
            <div class="border-t border-b border-gray-200 py-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Pilih Kamar</h2>
                
                <div>
                    <label for="selectedKamarId" class="block text-sm font-medium text-gray-700 mb-2">
                        Kamar yang Diinginkan
                    </label>
                    <select
                        wire:model.live="selectedKamarId"
                        wire:key="select-kamar-{{ $selectedKamarId }}"
                        id="selectedKamarId"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                    >
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($kamars as $kamar)
                            <option value="{{ $kamar->id_kamar }}">
                                Kamar {{ $kamar->nomor_kamar }} - {{ $kamar->tipe->nama_tipe }} (Rp {{ number_format($kamar->tipe->harga_dasar, 0, ',', '.') }}/malam)
                            </option>
                        @endforeach
                    </select>
                    @error('selectedKamarId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Tanggal Check-in & Check-out -->
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">Tanggal Penginap</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="tgl_check_in" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Check-in
                        </label>
                        <input 
                            wire:model.live="tgl_check_in"
                            type="date" 
                            id="tgl_check_in" 
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        >
                        @error('tgl_check_in') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tgl_check_out" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Check-out
                        </label>
                        <input 
                            wire:model.live="tgl_check_out"
                            type="date" 
                            id="tgl_check_out" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"
                        >
                        @error('tgl_check_out') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-gray-700"><strong>Total Malam:</strong> {{ $total_malam }} malam</p>
                    <p class="text-sm text-gray-700 mt-1"><strong>Total Harga:</strong> Rp {{ number_format($total_harga, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Data Pribadi -->
            <div class="border-t border-b border-gray-200 py-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">Data Pemesan</h2>
                
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                    <input wire:model="nama" type="text" id="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">NIK (Nomor Identitas) *</label>
                    <input wire:model="nik" type="text" id="nik" maxlength="20" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    @error('nik') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="nohp" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                    <input wire:model="nohp" type="tel" id="nohp" maxlength="15" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    @error('nohp') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Metode Pembayaran & Catatan -->
            <div class="space-y-4">
                <div>
                    <label for="pilihan_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran *</label>
                    <select wire:model="pilihan_pembayaran" id="pilihan_pembayaran" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        <option value="cash">Tunai (Bayar di Tempat)</option>
                        <option value="transfer">Transfer Bank</option>
                        <option value="kartu_kredit">Kartu Kredit</option>
                    </select>
                    @error('pilihan_pembayaran') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Khusus</label>
                    <textarea wire:model="catatan" id="catatan" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                    @error('catatan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200">
                    Lanjutkan Pemesanan
                </button>
            </div>
        </form>
    @endif
</div>
