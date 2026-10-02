<?php

namespace Database\Seeders;

use App\Models\TipeKamar;
use App\Models\Kamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create room types
        $suite = TipeKamar::create([
            'nama_tipe' => 'Suite',
            'harga_dasar' => 500000,
            'max_tamu' => 4,
        ]);

        $deluxe = TipeKamar::create([
            'nama_tipe' => 'Deluxe',
            'harga_dasar' => 350000,
            'max_tamu' => 2,
        ]);

        $standard = TipeKamar::create([
            'nama_tipe' => 'Standard',
            'harga_dasar' => 250000,
            'max_tamu' => 2,
        ]);

        // Create rooms for each type
        Kamar::create([
            'id_tipe' => $suite->id_tipe,
            'nomor_kamar' => '101',
            'deskripsi' => 'Suite Room with City View',
            'status_ketersediaan' => 'available',
        ]);

        Kamar::create([
            'id_tipe' => $suite->id_tipe,
            'nomor_kamar' => '102',
            'deskripsi' => 'Suite Room with Ocean View',
            'status_ketersediaan' => 'available',
        ]);

        Kamar::create([
            'id_tipe' => $deluxe->id_tipe,
            'nomor_kamar' => '201',
            'deskripsi' => 'Deluxe Room with Balcony',
            'status_ketersediaan' => 'available',
        ]);

        Kamar::create([
            'id_tipe' => $deluxe->id_tipe,
            'nomor_kamar' => '202',
            'deskripsi' => 'Deluxe Room with Garden View',
            'status_ketersediaan' => 'available',
        ]);

        Kamar::create([
            'id_tipe' => $standard->id_tipe,
            'nomor_kamar' => '301',
            'deskripsi' => 'Standard Room',
            'status_ketersediaan' => 'available',
        ]);

        Kamar::create([
            'id_tipe' => $standard->id_tipe,
            'nomor_kamar' => '302',
            'deskripsi' => 'Standard Room with Extra Bed',
            'status_ketersediaan' => 'available',
        ]);
    }
}
