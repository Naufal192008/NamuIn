<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TamuPublikController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BukuTamuController;
use App\Http\Controllers\Admin\KategoriTamuController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PegawaiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TamuPublikController::class, 'index'])->name('home');
Route::post('/check-in', [TamuPublikController::class, 'store'])->name('checkin.store');

Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/display', [TamuPublikController::class, 'display'])->name('display');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/buku-tamu', [BukuTamuController::class, 'index'])->name('buku-tamu.index');
    Route::post('/buku-tamu', [BukuTamuController::class, 'store'])->name('buku-tamu.store');
    Route::patch('/buku-tamu/{tamu}/status', [BukuTamuController::class, 'updateStatus'])->name('buku-tamu.status');
    Route::delete('/buku-tamu/{tamu}', [BukuTamuController::class, 'destroy'])->name('buku-tamu.destroy');

    Route::get('/kategori-tamu', [KategoriTamuController::class, 'index'])->name('kategori-tamu.index');
    Route::post('/kategori-tamu', [KategoriTamuController::class, 'store'])->name('kategori-tamu.store');
    Route::patch('/kategori-tamu/{kategoriTamu}', [KategoriTamuController::class, 'update'])->name('kategori-tamu.update');
    Route::delete('/kategori-tamu/{kategoriTamu}', [KategoriTamuController::class, 'destroy'])->name('kategori-tamu.destroy');

    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::patch('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::patch('/pegawai/{pegawai}/toggle', [PegawaiController::class, 'toggleAktif'])->name('pegawai.toggle');
    Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
});
