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
        Schema::create('tamu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tamu');
            $table->string('instansi');
            $table->string('no_wa');
            
            // Foreign Key to kategori_tamu
            $table->foreignId('kategori_id')
                  ->constrained('kategori_tamu')
                  ->onDelete('cascade');
                  
            $table->string('tujuan_kunjungan');
            $table->text('detail_keperluan');
            $table->text('catatan_internal')->nullable();
            
            // Foreign Key to users (handled_by)
            $table->foreignId('handled_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
                  
            $table->timestamp('jam_masuk')->useCurrent();
            $table->dateTime('jam_pulang')->nullable();
            $table->enum('status', ['Menunggu', 'Sedang Ditemui', 'Selesai'])->default('Menunggu');
            $table->string('keterangan_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamu');
    }
};
