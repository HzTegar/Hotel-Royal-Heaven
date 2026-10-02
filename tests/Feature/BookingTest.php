<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\TipeKamar;
use App\Models\Kamar;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_create_booking()
    {
        // create tipe and kamar
        $tipe = TipeKamar::create(["nama_tipe" => "Deluxe", "harga_dasar" => 500000, "max_tamu" => 2]);
        $kamar = Kamar::create(["nomor_kamar" => "101", "id_tipe" => $tipe->id_tipe, "deskripsi" => "Test", "status_ketersediaan" => 'available']);

        // register user via api
        $register = $this->postJson('/api/register', [
            'username' => 'member1',
            'email' => 'member1@example.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertStatus(201)->json();

        $token = $register['api_token'];

        $payload = [
            'id_kamar' => $kamar->id_kamar,
            'tgl_check_in' => now()->addDays(1)->toDateString(),
            'tgl_check_out' => now()->addDays(3)->toDateString(),
            'pilihan_pembayaran' => 'cash',
        ];

        $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/bookings', $payload)
            ->assertStatus(201)
            ->assertJsonStructure(['data' => ['id_pemesanan','kode_pemesanan','total_malam','total_harga','status_pemesanan']]);
    }
}
