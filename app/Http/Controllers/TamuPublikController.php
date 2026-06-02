<?php

namespace App\Http\Controllers;

use App\Models\KategoriTamu;
use App\Models\Tamu;
use Illuminate\Http\Request;

class TamuPublikController extends Controller
{
    public function index()
    {
        $kategoris = KategoriTamu::orderBy('nama_kategori')->get();
        return view('publik.form', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu'        => 'required|string|max:100',
            'instansi'         => 'required|string|max:100',
            'no_wa'            => 'required|string|max:20',
            'kategori_id'      => 'required|exists:kategori_tamu,id',
            'tujuan_kunjungan' => 'required|string|max:150',
            'detail_keperluan' => 'nullable|string|max:500',
        ], [
            'nama_tamu.required'        => 'Nama lengkap wajib diisi.',
            'instansi.required'         => 'Asal instansi wajib diisi.',
            'no_wa.required'            => 'Nomor WhatsApp wajib diisi.',
            'kategori_id.required'      => 'Pilih kategori kunjungan.',
            'kategori_id.exists'        => 'Kategori tidak valid.',
            'tujuan_kunjungan.required' => 'Tujuan kunjungan wajib diisi.',
        ]);

        Tamu::create([
            'nama_tamu'        => $request->nama_tamu,
            'instansi'         => $request->instansi,
            'no_wa'            => $request->no_wa,
            'kategori_id'      => $request->kategori_id,
            'tujuan_kunjungan' => $request->tujuan_kunjungan,
            'detail_keperluan' => $request->detail_keperluan,
            'status'           => 'Menunggu',
        ]);

        return redirect('/')->with('success', 'Terima kasih! Check-in Anda berhasil dicatat. Silakan menunggu.');
    }
}
