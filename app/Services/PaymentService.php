<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Create payment record for booking
     */
    public function createPayment(Pemesanan $pemesanan, string $paymentMethod = 'cash'): Payment
    {
        // Create payment record
        $payment = Payment::create([
            'pemesanan_id' => $pemesanan->id_pemesanan,
            'payment_method' => $paymentMethod,
            'transaction_id' => $this->generateTransactionId($paymentMethod),
            'order_id' => $this->generateOrderId($pemesanan),
            'amount' => $pemesanan->total_harga,
            'currency' => 'IDR',
            'status' => $paymentMethod === 'cash' ? 'pending' : 'processing',
        ]);

        // Update booking payment status
        $pemesanan->update([
            'payment_status' => $paymentMethod === 'cash' ? 'pending' : 'processing',
        ]);

        return $payment;
    }

    /**
     * Process cash payment confirmation
     */
    public function confirmCashPayment(Pemesanan $pemesanan): bool
    {
        try {
            $payment = $pemesanan->payment ?? $this->createPayment($pemesanan, 'cash');

            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            $pemesanan->update([
                'payment_status' => 'paid',
                'status_pemesanan' => 'confirmed',
            ]);

            // Update room status to booked
            if ($pemesanan->kamar) {
                $pemesanan->kamar->update(['status_ketersediaan' => 'booked']);
            }

            Log::info("Cash payment confirmed for booking: {$pemesanan->kode_pemesanan}");
            return true;

        } catch (\Exception $e) {
            Log::error("Failed to confirm cash payment: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Process Midtrans payment (simulated for development)
     */
    public function processMidtransPayment(Pemesanan $pemesanan): array
    {
        // Create payment record
        $payment = $this->createPayment($pemesanan, 'midtrans');

        // Simulate Midtrans response (since no real bank account)
        $response = [
            'transaction_id' => $payment->transaction_id,
            'order_id' => $payment->order_id,
            'payment_url' => route('member.pemesanan.payment', $pemesanan->id_pemesanan),
            'status' => 'pending',
            'snap_token' => $this->generateSnapToken($payment),
        ];

        // Update booking with payment details
        $pemesanan->update([
            'midtrans_transaction_id' => $payment->transaction_id,
            'payment_url' => $response['payment_url'],
        ]);

        return $response;
    }

    /**
     * Handle Midtrans payment notification (simulated)
     */
    public function handleMidtransNotification(array $notificationData): bool
    {
        try {
            $orderId = $notificationData['order_id'] ?? null;
            $transactionStatus = $notificationData['transaction_status'] ?? 'pending';

            if (!$orderId) {
                Log::error('Midtrans notification missing order_id');
                return false;
            }

            $payment = Payment::where('order_id', $orderId)->first();
            if (!$payment) {
                Log::error("Payment not found for order_id: {$orderId}");
                return false;
            }

            $pemesanan = $payment->pemesanan;
            if (!$pemesanan) {
                Log::error("Booking not found for payment: {$payment->id}");
                return false;
            }

            // Update payment status based on notification
            $paymentStatus = $this->mapMidtransStatus($transactionStatus);
            $payment->update([
                'status' => $paymentStatus,
                'payment_data' => $notificationData,
                'paid_at' => $paymentStatus === 'paid' ? now() : null,
            ]);

            // Update booking status
            $bookingStatus = $paymentStatus === 'paid' ? 'confirmed' : 'pending';
            $pemesanan->update([
                'payment_status' => $paymentStatus,
                'status_pemesanan' => $bookingStatus,
            ]);

            // Update room status if payment successful
            if ($paymentStatus === 'paid' && $pemesanan->kamar) {
                $pemesanan->kamar->update(['status_ketersediaan' => 'booked']);
            }

            Log::info("Midtrans payment notification processed for order: {$orderId}, status: {$paymentStatus}");
            return true;

        } catch (\Exception $e) {
            Log::error("Failed to process Midtrans notification: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Get payment status for booking
     */
    public function getPaymentStatus(Pemesanan $pemesanan): array
    {
        $payment = $pemesanan->payment;

        return [
            'payment_method' => $pemesanan->pilihan_pembayaran,
            'payment_status' => $pemesanan->payment_status ?? 'pending',
            'transaction_id' => $payment->transaction_id ?? null,
            'order_id' => $payment->order_id ?? null,
            'amount' => $pemesanan->total_harga,
            'has_payment_record' => $payment !== null,
            'is_paid' => $payment ? $payment->isPaid() : false,
        ];
    }

    /**
     * Generate unique transaction ID
     */
    private function generateTransactionId(string $method): string
    {
        $prefix = $method === 'midtrans' ? 'MT' : 'CSH';
        return $prefix . time() . rand(1000, 9999);
    }

    /**
     * Generate order ID
     */
    private function generateOrderId(Pemesanan $pemesanan): string
    {
        return 'ORD-' . date('Ymd') . '-' . str_pad($pemesanan->id_pemesanan, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate mock Snap token for Midtrans
     */
    private function generateSnapToken(Payment $payment): string
    {
        return 'SNAP-' . Str::random(32);
    }

    /**
     * Map Midtrans status to internal status
     */
    private function mapMidtransStatus(string $midtransStatus): string
    {
        $statusMap = [
            'capture' => 'paid',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny' => 'failed',
            'cancel' => 'cancelled',
            'expire' => 'failed',
            'failure' => 'failed',
        ];

        return $statusMap[$midtransStatus] ?? 'pending';
    }
}
