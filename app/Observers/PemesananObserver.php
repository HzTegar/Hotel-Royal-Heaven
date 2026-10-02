<?php

namespace App\Observers;

use App\Models\Pemesanan;

class PemesananObserver
{
    /**
     * Handle the Pemesanan "created" event.
     */
    public function created(Pemesanan $pemesanan): void
    {
        $this->updateRoomStatus($pemesanan);
    }

    /**
     * Handle the Pemesanan "updated" event.
     */
    public function updated(Pemesanan $pemesanan): void
    {
        // Only update room status if status_pemesanan has changed
        if ($pemesanan->wasChanged('status_pemesanan')) {
            $this->updateRoomStatus($pemesanan);
        }
    }

    /**
     * Update room status based on booking status
     */
    private function updateRoomStatus(Pemesanan $pemesanan): void
    {
        $status = $pemesanan->status_pemesanan;

        if ($pemesanan->kamar) {
            if ($status === 'confirmed') {
                // When confirmed, room becomes booked
                $pemesanan->kamar->status_ketersediaan = 'booked';
                $pemesanan->kamar->save();
            } elseif ($status === 'cancelled') {
                // When cancelled, room becomes available again
                $pemesanan->kamar->status_ketersediaan = 'available';
                $pemesanan->kamar->save();
            } elseif ($status === 'completed') {
                // When completed, room becomes available again
                $pemesanan->kamar->status_ketersediaan = 'available';
                $pemesanan->kamar->save();
            }
        }
    }
}
