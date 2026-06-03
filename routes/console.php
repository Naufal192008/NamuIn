<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\Tamu;

Schedule::call(function () {
    $updatedCount = Tamu::whereIn('status', ['Menunggu', 'Sedang Ditemui'])
        ->whereDate('jam_masuk', '<=', today())
        ->update([
            'status' => 'Selesai',
            'jam_pulang' => now()
        ]);
    
    if ($updatedCount > 0) {
        logger("Auto-checkout: {$updatedCount} active guest sessions automatically marked 'Selesai'.");
    }
})->dailyAt('17:00')->timezone('Asia/Jakarta');
