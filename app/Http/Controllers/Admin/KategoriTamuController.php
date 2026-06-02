<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriTamu;
use Illuminate\Http\Request;

class KategoriTamuController extends Controller
{
    public function index()
    {
        $kategoris = KategoriTamu::withCount('tamu')->get();
        return view('admin.kategori-tamu', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategori_tamu,nama_kategori',
            'warna'         => 'required|string',
        ], ['nama_kategori.unique' => 'Kategori ini sudah ada.']);

        KategoriTamu::create($request->only('nama_kategori', 'warna'));
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriTamu $kategoriTamu)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategori_tamu,nama_kategori,' . $kategoriTamu->id,
            'warna'         => 'required|string',
        ]);

        $kategoriTamu->update($request->only('nama_kategori', 'warna'));
        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriTamu $kategoriTamu)
    {
        if ($kategoriTamu->tamu()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan.');
        }
        $kategoriTamu->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
