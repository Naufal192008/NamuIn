@extends('layouts.admin')
@section('title', 'Laporan Kunjungan')
@section('page-title', 'Laporan Kunjungan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-size:18px;font-weight:700">Data Kunjungan</h2>
        <p style="font-size:13px;color:#64748b;margin-top:2px">Pantau dan ekspor data tamu sekolah Anda dengan mudah.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.laporan.index', array_merge(request()->query(), ['export' => 'excel'])) }}"
           class="btn btn-primary btn-sm">📥 Export Excel</a>
        <a href="{{ route('admin.laporan.index', array_merge(request()->query(), ['export' => 'pdf'])) }}"
           class="btn btn-ghost btn-sm">📄 Export PDF</a>
    </div>
</div>

<div class="card mb-6" style="padding:20px">
    <form method="GET" class="flex gap-3 items-end flex-wrap">
        <div class="form-group" style="margin:0;flex:1;min-width:200px">
            <label class="form-label">Rentang Tanggal</label>
            <div class="flex gap-2 items-center">
                <input type="date" name="dari" value="{{ $dari }}" class="form-control" style="flex:1">
                <span style="color:#94a3b8;font-size:12px">—</span>
                <input type="date" name="sampai" value="{{ $sampai }}" class="form-control" style="flex:1">
            </div>
        </div>
        <div class="form-group" style="margin:0;width:220px">
            <label class="form-label">Kategori Tamu</label>
            <select name="kategori" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                <option value="{{ $k->id }}" {{ $kategori == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="height:38px;margin-bottom:16px">≡ Terapkan Filter</button>
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tamu</th>
                <th>Instansi / Kategori</th>
                <th>Tujuan</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjungan as $i => $tamu)
            <tr>
                <td style="color:#94a3b8;font-size:12px">{{ str_pad(($kunjungan->currentPage() - 1) * $kunjungan->perPage() + $i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                <td style="font-weight:600;font-size:13px">{{ $tamu->nama_tamu }}</td>
                <td>
                    <div style="font-size:12px;color:#64748b">{{ $tamu->instansi }}</div>
                    @if($tamu->kategori)
                    <span class="tag" style="background:{{ $tamu->kategori->warna }}22;color:{{ $tamu->kategori->warna }};margin-top:3px">
                        {{ strtoupper($tamu->kategori->nama_kategori) }}
                    </span>
                    @endif
                </td>
                <td style="font-size:13px">{{ $tamu->tujuan_kunjungan }}</td>
                <td style="font-size:12px;color:#374151">{{ $tamu->jam_masuk->format('H:i') }}</td>
                <td style="font-size:12px;color:#374151">{{ $tamu->jam_pulang ? $tamu->jam_pulang->format('H:i') : '—' }}</td>
                <td>
                    @if($tamu->status === 'Menunggu')
                        <span class="badge badge-menunggu">{{ $tamu->status }}</span>
                    @elseif($tamu->status === 'Sedang Ditemui')
                        <span class="badge badge-ditemui">Ditemui</span>
                    @else
                        <span class="badge badge-selesai">{{ $tamu->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:40px">Tidak ada data untuk filter ini</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-info">Menampilkan {{ $kunjungan->firstItem() ?? 0 }}-{{ $kunjungan->lastItem() ?? 0 }} dari {{ $kunjungan->total() }} kunjungan</div>
    <div class="pagination">{{ $kunjungan->links() }}</div>
</div>
@endsection
