<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriTamu;
use App\Models\Tamu;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();

        $menunggu   = Tamu::whereDate('jam_masuk', $today)->where('status', 'Menunggu')->count();
        $ditemui    = Tamu::whereDate('jam_masuk', $today)->where('status', 'Sedang Ditemui')->count();
        $totalHari  = Tamu::whereDate('jam_masuk', $today)->count();

        $kunjunganHariIni = Tamu::with(['kategori', 'pegawaiTujuan'])
            ->whereDate('jam_masuk', $today)
            ->orderBy('jam_masuk', 'desc')
            ->paginate(10);

        $kategoriStats = KategoriTamu::withCount(['tamu as total_hari_ini' => function ($q) use ($today) {
            $q->whereDate('jam_masuk', $today);
        }])->get();

        return view('admin.dashboard', compact(
            'menunggu', 'ditemui', 'totalHari',
            'kunjunganHariIni', 'kategoriStats'
        ));
    }
}
