<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriTamu;
use App\Models\Tamu;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private function buildQuery(Request $request)
    {
        $dari    = $request->get('dari', today()->startOfMonth()->toDateString());
        $sampai  = $request->get('sampai', today()->toDateString());
        $kategori = $request->get('kategori', '');

        $query = Tamu::with('kategori')
            ->whereBetween('jam_masuk', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);

        if ($kategori) {
            $query->where('kategori_id', $kategori);
        }

        return [$query, $dari, $sampai, $kategori];
    }

    public function index(Request $request)
    {
        [$query, $dari, $sampai, $kategori] = $this->buildQuery($request);

        $kunjungan = $query->orderBy('jam_masuk', 'desc')->paginate(15)->withQueryString();
        $kategoris = KategoriTamu::all();

        return view('admin.laporan', compact('kunjungan', 'kategoris', 'dari', 'sampai', 'kategori'));
    }

    public function exportExcel(Request $request)
    {
        [$query, $dari, $sampai, $kategori] = $this->buildQuery($request);
        $data = $query->orderBy('jam_masuk', 'asc')->get();

        $filename = 'laporan-kunjungan-' . $dari . '-sd-' . $sampai . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['No', 'Nama Tamu', 'Instansi', 'Kategori', 'Tujuan Kunjungan', 'Detail Keperluan', 'Masuk', 'Keluar', 'Durasi', 'Status'], ';');

            foreach ($data as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    $row->nama_tamu,
                    $row->instansi,
                    $row->kategori?->nama_kategori ?? '-',
                    $row->tujuan_kunjungan,
                    $row->detail_keperluan ?? '-',
                    $row->jam_masuk->format('d/m/Y H:i'),
                    $row->jam_pulang ? $row->jam_pulang->format('d/m/Y H:i') : '-',
                    $row->durasi,
                    $row->status,
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        [$query, $dari, $sampai, $kategori] = $this->buildQuery($request);
        $data      = $query->orderBy('jam_masuk', 'asc')->get();
        $kategoris = KategoriTamu::all();

        return view('admin.laporan-pdf', compact('data', 'dari', 'sampai'));
    }
}
