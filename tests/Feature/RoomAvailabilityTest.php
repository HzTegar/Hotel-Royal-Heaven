<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\TipeKamar;
use App\Models\Kamar;
use App\Models\Pemesanan;

class RoomAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $tipe;
    private $kamar1;
    private $kamar2;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->tipe = TipeKamar::create([
            "nama_tipe" => "Deluxe",
            "harga_dasar" => 500000,
            "max_tamu" => 2
        ]);

        $this->kamar1 = Kamar::create([
            "nomor_kamar" => "101",
            "id_tipe" => $this->tipe->id_tipe,
            "deskripsi" => "Test Room 1",
            "status_ketersediaan" => 'available'
        ]);

        $this->kamar2 = Kamar::create([
            "nomor_kamar" => "102",
            "id_tipe" => $this->tipe->id_tipe,
            "deskripsi" => "Test Room 2",
            "status_ketersediaan" => 'available'
        ]);

        $this->user = User::factory()->create();
    }

    public function test_only_available_rooms_shown_in_member_room_list()
    {
        // Mark one room as booked
        $this->kamar1->update(['status_ketersediaan' => 'booked']);

        $response = $this->actingAs($this->user)
            ->get('/member/kamar');

        $response->assertStatus(200);

        // Check that only available room is shown
        $response->assertSee($this->kamar2->nomor_kamar)
            ->assertDontSee($this->kamar1->nomor_kamar);
    }

    public function test_room_status_updates_when_booking_confirmed()
    {
        // Create a pending booking
        $pemesanan = Pemesanan::create([
            'kode_pemesanan' => 'TEST001',
            'id_user' => $this->user->id,
            'id_kamar' => $this->kamar1->id_kamar,
            'nama_pemesan' => 'Test User',
            'nik' => '1234567890123456',
            'nohp' => '081234567890',
            'tgl_check_in' => now()->addDays(1)->toDateString(),
            'tgl_check_out' => now()->addDays(3)->toDateString(),
            'total_malam' => 2,
            'total_harga' => 1000000,
            'pilihan_pembayaran' => 'cash',
            'status_pemesanan' => 'pending',
            'payment_status' => 'pending',
            'tgl_pemesanan' => now()
        ]);

        // Confirm the booking (simulate admin action)
        $pemesanan->update(['status_pemesanan' => 'confirmed']);

        // Check that room status is updated to booked
        $this->kamar1->refresh();
        $this->assertEquals('booked', $this->kamar1->status_ketersediaan);
    }

    public function test_room_status_updates_when_booking_cancelled()
    {
        // Create a confirmed booking
        $pemesanan = Pemesanan::create([
            'kode_pemesanan' => 'TEST001',
            'id_user' => $this->user->id,
            'id_kamar' => $this->kamar1->id_kamar,
            'nama_pemesan' => 'Test User',
            'nik' => '1234567890123456',
            'nohp' => '081234567890',
            'tgl_check_in' => now()->addDays(1)->toDateString(),
            'tgl_check_out' => now()->addDays(3)->toDateString(),
            'total_malam' => 2,
            'total_harga' => 1000000,
            'pilihan_pembayaran' => 'cash',
            'status_pemesanan' => 'confirmed',
            'payment_status' => 'paid',
            'tgl_pemesanan' => now()
        ]);

        // Room should be booked
        $this->kamar1->refresh();
        $this->assertEquals('booked', $this->kamar1->status_ketersediaan);

        // Cancel the booking
        $pemesanan->update(['status_pemesanan' => 'cancelled']);

        // Check that room status is updated back to available
        $this->kamar1->refresh();
        $this->assertEquals('available', $this->kamar1->status_ketersediaan);
    }

    public function test_room_becomes_available_after_checkout_date()
    {
        // Create a completed booking (past dates)
        $pemesanan = Pemesanan::create([
            'kode_pemesanan' => 'TEST001',
            'id_user' => $this->user->id,
            'id_kamar' => $this->kamar1->id_kamar,
            'nama_pemesan' => 'Test User',
            'nik' => '1234567890123456',
            'nohp' => '081234567890',
            'tgl_check_in' => now()->subDays(3)->toDateString(),
            'tgl_check_out' => now()->subDays(1)->toDateString(), // Past date
            'total_malam' => 2,
            'total_harga' => 1000000,
            'pilihan_pembayaran' => 'cash',
            'status_pemesanan' => 'completed',
            'payment_status' => 'paid',
            'tgl_pemesanan' => now()->subDays(5)
        ]);

        // Room should be available for new bookings
        $response = $this->actingAs($this->user)
            ->postJson('/member/pemesanan', [
                'id_kamar' => $this->kamar1->id_kamar,
                'nik' => '1234567890123456',
                'nama' => 'Test User',
                'nohp' => '081234567890',
                'tgl_check_in' => now()->addDays(1)->toDateString(),
                'tgl_check_out' => now()->addDays(3)->toDateString(),
                'pilihan_pembayaran' => 'cash'
            ]);

        $response->assertStatus(302); // Should succeed
    }

    public function test_multiple_bookings_same_room_blocked()
    {
        // Create first booking
        Pemesanan::create([
            'kode_pemesanan' => 'TEST001',
            'id_user' => $this->user->id,
            'id_kamar' => $this->kamar1->id_kamar,
            'nama_pemesan' => 'Test User 1',
            'nik' => '1234567890123456',
            'nohp' => '081234567890',
            'tgl_check_in' => now()->addDays(1)->toDateString(),
            'tgl_check_out' => now()->addDays(3)->toDateString(),
            'total_malam' => 2,
            'total_harga' => 1000000,
            'pilihan_pembayaran' => 'cash',
            'status_pemesanan' => 'confirmed',
            'payment_status' => 'paid',
            'tgl_pemesanan' => now()
        ]);

        // Try to create overlapping booking
        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)
            ->postJson('/member/pemesanan', [
                'id_kamar' => $this->kamar1->id_kamar,
                'nik' => '1234567890123456',
                'nama' => 'Test User 2',
                'nohp' => '081234567890',
                'tgl_check_in' => now()->addDays(2)->toDateString(), // Overlapping
                'tgl_check_out' => now()->addDays(4)->toDateString(),
                'pilihan_pembayaran' => 'cash'
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['id_kamar']);
    }

    public function test_room_filter_component_shows_only_available_rooms()
    {
        // Mark one room as booked
        $this->kamar1->update(['status_ketersediaan' => 'booked']);

        $response = $this->actingAs($this->user)
            ->get('/member/kamar?type=' . $this->tipe->id_tipe);

        $response->assertStatus(200)
            ->assertSee($this->kamar2->nomor_kamar)
            ->assertDontSee($this->kamar1->nomor_kamar);
    }
}
