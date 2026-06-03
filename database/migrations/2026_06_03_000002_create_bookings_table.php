<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tamu');
            $table->string('instansi');
            $table->string('no_wa');
            $table->foreignId('kategori_id')->constrained('kategori_tamu')->onDelete('cascade');
            $table->string('tujuan_kunjungan');
            $table->foreignId('bertemu_dengan')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->text('detail_keperluan')->nullable();
            $table->date('tanggal_booking');
            $table->time('jam_booking');
            $table->string('booking_code')->unique();
            $table->enum('status', ['Diajukan', 'Disetujui', 'Ditolak', 'Checkin', 'Batal'])->default('Diajukan');
            $table->text('catatan_staf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
