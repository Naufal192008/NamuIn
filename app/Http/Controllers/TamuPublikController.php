<?php

namespace App\Http\Controllers;

use App\Models\KategoriTamu;
use App\Models\Pegawai;
use App\Models\Tamu;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class TamuPublikController extends Controller
{
    public function index()
    {
        $kategoris = KategoriTamu::orderBy('nama_kategori')->get();
        $pegawais  = Pegawai::where('aktif', true)->orderBy('nama')->get();
        return view('publik.form', compact('kategoris', 'pegawais'));
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
        ], [
            'nama_tamu.required'        => 'Nama lengkap wajib diisi.',
            'instansi.required'         => 'Asal instansi wajib diisi.',
            'no_wa.required'            => 'Nomor WhatsApp wajib diisi.',
            'kategori_id.required'      => 'Pilih kategori kunjungan.',
            'tujuan_kunjungan.required' => 'Tujuan kunjungan wajib diisi.',
        ]);

        $tamu = Tamu::create([
            'nama_tamu'        => $request->nama_tamu,
            'instansi'         => $request->instansi,
            'no_wa'            => $request->no_wa,
            'kategori_id'      => $request->kategori_id,
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'bertemu_dengan'   => $request->bertemu_dengan ?: null,
            'detail_keperluan' => $request->detail_keperluan,
            'status'           => 'Menunggu',
        ]);

        if ($tamu->bertemu_dengan) {
            $tamu->load('pegawaiTujuan.kategori');
            app(WhatsAppService::class)->kirimNotifikasiTamu($tamu);
        }

        return redirect('/')->with('success', 'Terima kasih! Check-in Anda berhasil dicatat. Silakan menunggu dipanggil.');
    }

    public function display()
    {
        $checkinUrl = url('/?from=qr');
        return view('publik.display', compact('checkinUrl'));
    }
}
