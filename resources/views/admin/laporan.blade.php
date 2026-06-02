@extends('layouts.admin')
@section('title', 'Laporan Kunjungan — NamuIn')
@section('page-title', 'Laporan Kunjungan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-family:'Bricolage Grotesque',sans-serif;font-size:20px;font-weight:800">Laporan Kunjungan</h2>
        <p style="font-size:13px;color:var(--text-muted);margin-top:2px">Pantau dan ekspor data kunjungan tamu sekolah.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.laporan.export-excel', request()->query()) }}" class="btn btn-primary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
            Export Excel
        </a>
        <a href="{{ route('admin.laporan.export-pdf', request()->query()) }}" target="_blank" class="btn btn-ghost btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" /></svg>
            Export PDF
        </a>
    </div>
</div>

<div class="card mb-6" style="padding:20px">
    <form method="GET" class="flex gap-3 items-end flex-wrap">
        <div class="form-group" style="margin:0;flex:1;min-width:240px">
            <label class="form-label">Rentang Tanggal</label>
            <div class="flex gap-2 items-center">
                <input type="date" name="dari" value="{{ $dari }}" class="form-control" style="flex:1">
                <span style="color:var(--text-muted);font-size:12px;flex-shrink:0">s.d.</span>
                <input type="date" name="sampai" value="{{ $sampai }}" class="form-control" style="flex:1">
            </div>
        </div>
        <div class="form-group" style="margin:0;width:200px">
            <label class="form-label">Kategori Tamu</label>
            <select name="kategori" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                <option value="{{ $k->id }}" {{ $kategori == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div style="margin-bottom:16px">
            <button type="submit" class="btn btn-secondary" style="height:38px">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" /></svg>
                Terapkan Filter
            </button>
        </div>
        @if(request()->hasAny(['dari', 'sampai', 'kategori']))
        <div style="margin-bottom:16px">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-ghost" style="height:38px">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                Reset
            </a>
        </div>
        @endif
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th style="width:44px">#</th>
                <th>Nama Tamu</th>
                <th>Instansi / Kategori</th>
                <th>Bertemu Dengan</th>
                <th>Tujuan</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Durasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kunjungan as $i => $tamu)
            <tr>
                <td style="color:var(--text-muted);font-size:12px;font-variant-numeric:tabular-nums">{{ str_pad(($kunjungan->currentPage() - 1) * $kunjungan->perPage() + $i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div style="font-weight:600;font-size:13px">{{ $tamu->nama_tamu }}</div>
                    <div style="font-size:11px;color:var(--text-muted)">{{ $tamu->no_wa }}</div>
                </td>
                <td>
                    <div style="font-size:12px;color:var(--text-muted)">{{ $tamu->instansi }}</div>
                    @if($tamu->kategori)
                    <span class="tag" style="background:{{ $tamu->kategori->warna }}22;color:{{ $tamu->kategori->warna }};margin-top:3px;display:inline-block">
                        {{ $tamu->kategori->nama_kategori }}
                    </span>
                    @endif
                </td>
                <td>
                    @if($tamu->pegawaiTujuan)
                    <div style="font-size:12px;font-weight:600">{{ $tamu->pegawaiTujuan->nama }}</div>
                    <div style="font-size:11px;color:var(--text-muted)">{{ $tamu->pegawaiTujuan->jabatan }}</div>
                    @else
                    <span style="color:var(--text-muted)">—</span>
                    @endif
                </td>
                <td style="font-size:12px;max-width:160px">{{ $tamu->tujuan_kunjungan }}</td>
                <td style="font-size:12px;white-space:nowrap">{{ $tamu->jam_masuk->format('d/m H:i') }}</td>
                <td style="font-size:12px;color:var(--text-muted);white-space:nowrap">{{ $tamu->jam_pulang ? $tamu->jam_pulang->format('H:i') : '—' }}</td>
                <td style="font-size:12px;color:var(--text-muted)">{{ $tamu->jam_pulang ? $tamu->durasi : '—' }}</td>
                <td>
                    @if($tamu->status === 'Menunggu')
                        <span class="badge badge-menunggu"><span class="badge-dot"></span>{{ $tamu->status }}</span>
                    @elseif($tamu->status === 'Sedang Ditemui')
                        <span class="badge badge-ditemui"><span class="badge-dot"></span>Ditemui</span>
                    @else
                        <span class="badge badge-selesai"><span class="badge-dot"></span>{{ $tamu->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:var(--text-muted);padding:48px">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:40px;height:40px;opacity:.2;margin:0 auto 10px;display:block"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                Tidak ada data untuk filter ini.
            </td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-info">Menampilkan {{ $kunjungan->firstItem() ?? 0 }}–{{ $kunjungan->lastItem() ?? 0 }} dari {{ $kunjungan->total() }} kunjungan</div>
    <div class="pagination">{{ $kunjungan->links() }}</div>
</div>
@endsection
