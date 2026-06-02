<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriTamu;
use App\Models\Tamu;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari    = $request->get('dari', today()->startOfMonth()->toDateString());
        $sampai  = $request->get('sampai', today()->toDateString());
        $kategori = $request->get('kategori', '');

        $query = Tamu::with('kategori')
            ->whereBetween('jam_masuk', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);

        if ($kategori) {
            $query->where('kategori_id', $kategori);
        }

        $kunjungan = $query->orderBy('jam_masuk', 'desc')->paginate(15)->withQueryString();
        $kategoris = KategoriTamu::all();

        return view('admin.laporan', compact('kunjungan', 'kategoris', 'dari', 'sampai', 'kategori'));
    }
}
