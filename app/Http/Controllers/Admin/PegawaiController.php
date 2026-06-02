<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::withCount('tamu')->orderBy('nama')->get();
        return view('admin.pegawai', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'nip'         => 'nullable|string|max:30|unique:pegawai,nip',
            'jabatan'     => 'required|string|max:100',
            'departemen'  => 'nullable|string|max:100',
            'no_wa'       => 'required|string|max:20',
            'email'       => 'nullable|email|max:100',
        ], ['nip.unique' => 'NIP sudah terdaftar.']);

        Pegawai::create($request->only('nama', 'nip', 'jabatan', 'departemen', 'no_wa', 'email') + ['aktif' => true]);
        return back()->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'nip'         => 'nullable|string|max:30|unique:pegawai,nip,' . $pegawai->id,
            'jabatan'     => 'required|string|max:100',
            'departemen'  => 'nullable|string|max:100',
            'no_wa'       => 'required|string|max:20',
            'email'       => 'nullable|email|max:100',
        ]);

        $pegawai->update($request->only('nama', 'nip', 'jabatan', 'departemen', 'no_wa', 'email'));
        return back()->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function toggleAktif(Pegawai $pegawai)
    {
        $pegawai->update(['aktif' => !$pegawai->aktif]);
        $status = $pegawai->aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Pegawai berhasil {$status}.");
    }

    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->tamu()->count() > 0) {
            return back()->with('error', 'Pegawai tidak bisa dihapus karena masih memiliki data kunjungan tamu.');
        }
        $pegawai->delete();
        return back()->with('success', 'Pegawai berhasil dihapus.');
    }
}
