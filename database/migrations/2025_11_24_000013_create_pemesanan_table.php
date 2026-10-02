<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->string('kode_pemesanan', 20)->unique();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kamar');
            $table->date('tgl_check_in');
            $table->date('tgl_check_out');
            $table->integer('total_malam')->default(1);
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->string('nama_pemesan', 150)->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('nohp', 15)->nullable();
            $table->string('pilihan_pembayaran', 50)->nullable();
            $table->text('catatan')->nullable();
            $table->string('status_pemesanan', 20)->default('pending');
            $table->string('payment_status')->default('pending');
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('payment_url')->nullable();
            $table->timestamp('tgl_pemesanan')->useCurrent();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kamar')->references('id_kamar')->on('kamar')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
