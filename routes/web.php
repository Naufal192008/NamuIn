<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TamuPublikController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuTamuController;
use App\Http\Controllers\Admin\KategoriTamuController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Webhook\WhatsAppWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TamuPublikController::class, 'index'])->name('home');
Route::post('/check-in', [TamuPublikController::class, 'store'])->name('checkin.store')->middleware('throttle:5,1');

// Pre-booking Routes
Route::get('/booking', [BookingController::class, 'showBookingForm'])->name('booking.form');
Route::post('/booking', [BookingController::class, 'storeBooking'])->name('booking.store')->middleware('throttle:5,1');
Route::post('/check-in/booking', [BookingController::class, 'checkinWithCode'])->name('checkin.booking')->middleware('throttle:5,1');

// Self-checkout Routes
Route::get('/check-out', [TamuPublikController::class, 'showCheckoutForm'])->name('checkout.form');
Route::post('/check-out', [TamuPublikController::class, 'checkoutByNameOrPhone'])->name('checkout.submit')->middleware('throttle:5,1');
Route::get('/check-out/success/{tamu}', [TamuPublikController::class, 'checkoutSuccess'])->name('checkout.success');
Route::get('/check-out/{tamu}', [TamuPublikController::class, 'directCheckout'])->name('checkout.direct');

Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/display', [TamuPublikController::class, 'display'])->name('display');
Route::get('/display/live-feed', [TamuPublikController::class, 'liveFeed'])->name('display.live-feed');
Route::post('/webhook/whatsapp', [WhatsAppWebhookController::class, 'handleWebhook'])->name('webhook.whatsapp');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/whatsapp-simulator', [WhatsAppWebhookController::class, 'simulator'])->name('whatsapp-simulator');
    Route::post('/whatsapp-simulator', [WhatsAppWebhookController::class, 'simulateWebhook'])->name('whatsapp-simulator.post');

    Route::get('/buku-tamu', [BukuTamuController::class, 'index'])->name('buku-tamu.index');
    Route::post('/buku-tamu', [BukuTamuController::class, 'store'])->name('buku-tamu.store');
    Route::patch('/buku-tamu/{tamu}/status', [BukuTamuController::class, 'updateStatus'])->name('buku-tamu.status');
    Route::delete('/buku-tamu/{tamu}', [BukuTamuController::class, 'destroy'])->name('buku-tamu.destroy');

    // Admin Only Configuration Routes
    Route::middleware('can:admin')->group(function () {
        Route::get('/kategori-tamu', [KategoriTamuController::class, 'index'])->name('kategori-tamu.index');
        Route::post('/kategori-tamu', [KategoriTamuController::class, 'store'])->name('kategori-tamu.store');
        Route::patch('/kategori-tamu/{kategoriTamu}', [KategoriTamuController::class, 'update'])->name('kategori-tamu.update');
        Route::delete('/kategori-tamu/{kategoriTamu}', [KategoriTamuController::class, 'destroy'])->name('kategori-tamu.destroy');

        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::patch('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::patch('/pegawai/{pegawai}/toggle', [PegawaiController::class, 'toggleAktif'])->name('pegawai.toggle');
        Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    });

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
});
