<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tamu', function (Blueprint $table) {
            $table->foreignId('bertemu_dengan')
                  ->nullable()
                  ->after('tujuan_kunjungan')
                  ->constrained('pegawai')
                  ->onDelete('set null');

            $table->timestamp('wa_sent_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('tamu', function (Blueprint $table) {
            $table->dropForeign(['bertemu_dengan']);
            $table->dropColumn(['bertemu_dengan', 'wa_sent_at']);
        });
    }
};
