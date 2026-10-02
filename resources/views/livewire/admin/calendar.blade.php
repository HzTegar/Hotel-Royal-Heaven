<div>
    <!-- Calendar Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <!-- Navigation -->
            <div class="flex items-center gap-4">
                <button wire:click="goToToday" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Today
                </button>
                <div class="flex items-center gap-2">
                    <button wire:click="previousMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-900 min-w-[200px] text-center">
                        {{ $monthName }}
                    </h2>
                    <button wire:click="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-4">
                <select wire:model.live="selectedRoomType" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Room Types</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id_tipe }}">{{ $type->nama_tipe }}</option>
                    @endforeach
                </select>

                <select wire:model.live="viewMode" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="month">Month View</option>
                    <option value="week">Week View</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Days Header -->
        <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
            @php
                $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            @endphp
            @foreach($days as $day)
                <div class="px-4 py-3 text-center text-sm font-medium text-gray-500 border-r border-gray-200 last:border-r-0">
                    {{ $day }}
                </div>
            @endforeach
        </div>

        <!-- Calendar Body -->
        <div class="max-h-[600px] overflow-y-auto">
            @if(count($calendarData) > 0)
                @foreach($calendarData as $room)
                    <div class="border-b border-gray-200 last:border-b-0">
                        <!-- Room Header -->
                        <div class="bg-gray-50 px-4 py-2 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <h3 class="font-medium text-gray-900">
                                        Room {{ $room['nomor_kamar'] }}
                                    </h3>
                                    <span class="text-sm text-gray-500">
                                        {{ $room['tipe_kamar'] }}
                                    </span>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($room['status_ketersediaan'] === 'available') bg-green-100 text-green-800
                                        @elseif($room['status_ketersediaan'] === 'booked') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($room['status_ketersediaan']) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Days Grid -->
                        <div class="grid grid-cols-7">
                            @php
                                $startDate = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1);
                                $firstDayOfWeek = $startDate->copy()->startOfMonth()->startOfWeek(\Carbon\Carbon::MONDAY);
                                $daysInMonth = $startDate->daysInMonth;
                                $dayCounter = 0;
                            @endphp

                            @while($dayCounter < 42) {{-- 6 weeks * 7 days --}}
                                @php
                                    $currentDate = $firstDayOfWeek->copy()->addDays($dayCounter);
                                    $isCurrentMonth = $currentDate->month === $currentMonth && $currentDate->year === $currentYear;
                                    $dayData = $isCurrentMonth ? ($room['days'][$currentDate->day - 1] ?? null) : null;
                                @endphp

                                <div class="min-h-[80px] border-r border-b border-gray-200 last:border-r-0 p-2
                                    @if(!$isCurrentMonth) bg-gray-50 @endif
                                    @if($dayData && $dayData['is_today']) ring-2 ring-blue-500 ring-inset @endif">

                                    @if($isCurrentMonth)
                                        <div class="text-sm font-medium text-gray-900 mb-1">
                                            {{ $currentDate->day }}
                                        </div>

                                        @if($dayData)
                                            <div class="space-y-1">
                                                @foreach($dayData['bookings'] as $booking)
                                                    <div wire:click="selectBooking({{ $booking['id'] }})"
                                                         class="px-2 py-1 text-xs rounded cursor-pointer transition-colors
                                                            @if($booking['status'] === 'confirmed') bg-red-100 text-red-800 hover:bg-red-200
                                                            @elseif($booking['status'] === 'pending') bg-yellow-100 text-yellow-800 hover:bg-yellow-200
                                                            @else bg-gray-100 text-gray-800 hover:bg-gray-200 @endif">
                                                        <div class="font-medium truncate">
                                                            {{ $booking['customer'] }}
                                                        </div>
                                                        <div class="text-xs opacity-75">
                                                            {{ $booking['kode_pemesanan'] }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>

                                @php $dayCounter++ @endphp
                            @endwhile
                        </div>
                    </div>
                @endforeach
            @else
                <div class="p-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No rooms found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or check if rooms exist in the system.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Booking Details Modal -->
    @if($selectedBooking)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="booking-modal">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Booking Details</h3>
                    <button wire:click="closeBookingModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Booking Code</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedBooking->kode_pemesanan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($selectedBooking->status_pemesanan === 'confirmed') bg-green-100 text-green-800
                                @elseif($selectedBooking->status_pemesanan === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($selectedBooking->status_pemesanan === 'completed') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($selectedBooking->status_pemesanan) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Customer</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedBooking->user->nama_lengkap ?? $selectedBooking->user->username }}</p>
                            <p class="text-xs text-gray-500">{{ $selectedBooking->user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Room</label>
                            <p class="mt-1 text-sm text-gray-900">Room {{ $selectedBooking->kamar->nomor_kamar }}</p>
                            <p class="text-xs text-gray-500">{{ $selectedBooking->kamar->tipe->nama_tipe }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Check-in</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedBooking->tgl_check_in ? \Carbon\Carbon::parse($selectedBooking->tgl_check_in)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Check-out</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedBooking->tgl_check_out ? \Carbon\Carbon::parse($selectedBooking->tgl_check_out)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nights</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedBooking->total_malam }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Price</label>
                            <p class="mt-1 text-sm text-gray-900">Rp {{ number_format($selectedBooking->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($selectedBooking->pilihan_pembayaran) }}</p>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button wire:click="closeBookingModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Custom scrollbar for calendar */
        .max-h-\[600px\]::-webkit-scrollbar {
            width: 6px;
        }

        .max-h-\[600px\]::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .max-h-\[600px\]::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .max-h-\[600px\]::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</div>
