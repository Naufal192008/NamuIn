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

        // Calculate statistics for the filtered period
        $dariTime = $dari . ' 00:00:00';
        $sampaiTime = $sampai . ' 23:59:59';

        // 1. Kategori Stats
        $kategoriStatsQuery = \App\Models\Tamu::select(
                'kategori_tamu.nama_kategori',
                'kategori_tamu.warna',
                \Illuminate\Support\Facades\DB::raw('count(*) as total')
            )
            ->join('kategori_tamu', 'tamu.kategori_id', '=', 'kategori_tamu.id')
            ->whereBetween('jam_masuk', [$dariTime, $sampaiTime]);
        if ($kategori) {
            $kategoriStatsQuery->where('tamu.kategori_id', $kategori);
        }
        $kategoriStats = $kategoriStatsQuery->groupBy('kategori_tamu.nama_kategori', 'kategori_tamu.warna')->get();

        // 2. Trend Harian
        $trendStatsQuery = \App\Models\Tamu::select(
                \Illuminate\Support\Facades\DB::raw('DATE(jam_masuk) as tanggal'),
                \Illuminate\Support\Facades\DB::raw('count(*) as total')
            )
            ->whereBetween('jam_masuk', [$dariTime, $sampaiTime]);
        if ($kategori) {
            $trendStatsQuery->where('kategori_id', $kategori);
        }
        $trendStats = $trendStatsQuery->groupBy(\Illuminate\Support\Facades\DB::raw('DATE(jam_masuk)'))
            ->orderBy('tanggal', 'asc')
            ->get();

        // 3. Jam Terpadat
        $jamStatsQuery = \App\Models\Tamu::select(
                \Illuminate\Support\Facades\DB::raw('HOUR(jam_masuk) as jam'),
                \Illuminate\Support\Facades\DB::raw('count(*) as total')
            )
            ->whereBetween('jam_masuk', [$dariTime, $sampaiTime]);
        if ($kategori) {
            $jamStatsQuery->where('kategori_id', $kategori);
        }
        $jamStats = $jamStatsQuery->groupBy(\Illuminate\Support\Facades\DB::raw('HOUR(jam_masuk)'))
            ->orderBy('jam', 'asc')
            ->get();

        // 4. Pegawai Terpopuler
        $pegawaiStatsQuery = \App\Models\Tamu::select(
                'pegawai.nama',
                'pegawai.jabatan',
                \Illuminate\Support\Facades\DB::raw('count(*) as total')
            )
            ->join('pegawai', 'tamu.bertemu_dengan', '=', 'pegawai.id')
            ->whereBetween('jam_masuk', [$dariTime, $sampaiTime]);
        if ($kategori) {
            $pegawaiStatsQuery->where('tamu.kategori_id', $kategori);
        }
        $pegawaiStats = $pegawaiStatsQuery->groupBy('pegawai.nama', 'pegawai.jabatan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('admin.laporan', compact(
            'kunjungan', 'kategoris', 'dari', 'sampai', 'kategori',
            'kategoriStats', 'trendStats', 'jamStats', 'pegawaiStats'
        ));
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
