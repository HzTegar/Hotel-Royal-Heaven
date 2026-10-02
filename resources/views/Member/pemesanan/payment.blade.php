@extends('layouts.app')

@section('title', 'Complete Your Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Complete Your Payment</h1>

            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Booking Code</p>
                        <p class="font-semibold text-lg">{{ $pemesanan->kode_pemesanan }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Amount</p>
                        <p class="font-semibold text-lg text-green-600">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Payment Method</p>
                        <p class="font-semibold">{{ ucfirst($pemesanan->pilihan_pembayaran) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Payment Status</p>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($pemesanan->payment_status === 'paid') bg-green-100 text-green-800
                            @elseif($pemesanan->payment_status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($pemesanan->payment_status ?? 'pending') }}
                        </span>
                    </div>
                </div>
            </div>

            @if($pemesanan->pilihan_pembayaran === 'cash')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Cash Payment Instructions</h3>
                    <p class="text-blue-700 mb-2">Please pay at the hotel reception on your check-in date.</p>
                    <p class="text-sm text-blue-600">The hotel staff will confirm your payment after you arrive.</p>
                </div>

                <div class="text-center">
                    <a href="{{ route('member.pemesanan.my') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                        Back to My Bookings
                    </a>
                </div>

            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Online Payment (Midtrans)</h3>
                    <p class="text-yellow-700 mb-2">This feature is currently in development mode.</p>
                    <p class="text-sm text-yellow-600">Since no bank account is configured, this payment method is simulated for demonstration purposes.</p>
                </div>

                <div class="text-center space-y-4">
                    <button id="pay-button" class="bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-8 rounded-lg transition duration-200">
                        Proceed with Payment (Demo)
                    </button>

                    <div class="text-sm text-gray-500">
                        <p>This will simulate a successful payment for demonstration purposes.</p>
                    </div>
                </div>

                <script type="text/javascript">
                    var payButton = document.getElementById('pay-button');
                    payButton.addEventListener('click', function () {
                        // Simulate payment success
                        alert('Payment simulation successful! Redirecting...');
                        window.location.href = "{{ route('member.pemesanan.my') }}";
                    });
                </script>
            @endif
        </div>
    </div>
</div>
@endsection
