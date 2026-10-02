<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id('id_kamar');
            $table->string('nomor_kamar', 10)->unique();
            $table->unsignedBigInteger('id_tipe');
            $table->text('deskripsi')->nullable();
            $table->string('status_ketersediaan', 50)->default('available');
            $table->string('foto_kamar')->nullable();
            $table->text('foto_detail')->nullable();
            $table->timestamps();

            $table->foreign('id_tipe')->references('id_tipe')->on('tipe_kamar')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
