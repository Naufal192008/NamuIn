<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriTamu;
use App\Models\Pegawai;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuTamuController extends Controller
{
    public function index(Request $request)
    {
        $today = today();
        $menunggu  = Tamu::whereDate('jam_masuk', $today)->where('status', 'Menunggu')->count();
        $totalHari = Tamu::whereDate('jam_masuk', $today)->count();

        $query = Tamu::with(['kategori', 'pegawaiTujuan'])->whereDate('jam_masuk', $today);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $kunjungan = $query->orderBy('jam_masuk', 'desc')->paginate(10)->withQueryString();
        $kategoris = KategoriTamu::all();
        $pegawais  = Pegawai::where('aktif', true)->orderBy('nama')->get();

        return view('admin.buku-tamu', compact('menunggu', 'totalHari', 'kunjungan', 'kategoris', 'pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu'        => 'required|string|max:100',
            'instansi'         => 'required|string|max:100',
            'no_wa'            => 'required|string|max:20',
            'kategori_id'      => 'required|exists:kategori_tamu,id',
            'tujuan_kunjungan' => 'required|string|max:150',
            'bertemu_dengan'   => 'nullable|exists:pegawai,id',
            'detail_keperluan' => 'nullable|string|max:500',
            'sudah_janji'      => 'nullable|boolean',
        ]);

        Tamu::create($request->only([
            'nama_tamu', 'instansi', 'no_wa', 'kategori_id',
            'tujuan_kunjungan', 'bertemu_dengan', 'detail_keperluan',
        ]) + [
            'sudah_janji' => $request->boolean('sudah_janji'),
            'status' => 'Menunggu'
        ]);

        return back()->with('success', 'Data kunjungan berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, Tamu $tamu)
    {
        $request->validate(['status' => 'required|in:Menunggu,Sedang Ditemui,Selesai']);

        $data = ['status' => $request->status];

        if ($request->status === 'Sedang Ditemui') {
            $data['handled_by'] = Auth::id();
        }
        if ($request->status === 'Selesai') {
            $data['jam_pulang'] = now();
        }

        $tamu->update($data);

        return back()->with('success', 'Status tamu berhasil diperbarui.');
    }

    public function destroy(Tamu $tamu)
    {
        $tamu->delete();
        return back()->with('success', 'Data kunjungan berhasil dihapus.');
    }
}
