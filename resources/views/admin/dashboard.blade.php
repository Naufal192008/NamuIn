@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Buku Tamu')

@section('content')
<div class="grid-3 mb-6">
    <div class="stat-card primary-border">
        <div class="stat-icon orange">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </div>
        <div class="stat-label">Tamu Menunggu</div>
        <div class="stat-value" style="color:var(--primary)">{{ $menunggu }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a.75.75 0 0 1-1.074-.83l1.207-4.52a8.919 8.919 0 0 1-.843-3.62C4.7 7.444 8.73 3.75 13.7 3.75c4.97 0 9 3.706 9 8.25Z" /></svg>
        </div>
        <div class="stat-label">Sedang Ditemui</div>
        <div class="stat-value" style="color:var(--tertiary)">{{ $ditemui }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
        </div>
        <div class="stat-label">Total Hari Ini</div>
        <div class="stat-value">{{ $totalHari }}</div>
    </div>
</div>

<div class="flex gap-3" style="align-items:flex-start">
    <div class="flex-1">
        <div class="card">
            <div class="card-header">
                <h3>Daftar Kunjungan Hari Ini</h3>
                <span style="font-size:12px;color:#64748b">≡ Filter</span>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Tamu</th>
                            <th>Kategori</th>
                            <th>Bertemu Dengan</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>WA</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kunjunganHariIni as $tamu)
                        <tr>
                            <td>
                                <div style="font-weight:600;font-size:13px">{{ $tamu->nama_tamu }}</div>
                                <div style="font-size:11px;color:var(--text-muted)">{{ $tamu->instansi }}</div>
                                @if($tamu->sudah_janji)
                                    <div style="margin-top:4px">
                                        <span class="badge" style="background:#EEF2FF; color:#4F46E5; border:1px solid #C7D2FE; font-size:9px; padding:1px 6px; border-radius:4px; display:inline-flex; align-items:center; gap:3px; font-weight:600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:10px;height:10px"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                            Ada Janji
                                        </span>
                                    </div>
                                @else
                                    <div style="margin-top:4px">
                                        <span class="badge" style="background:#F4F4F5; color:#71717A; border:1px solid #E4E4E7; font-size:9px; padding:1px 6px; border-radius:4px; display:inline-flex; align-items:center; gap:3px; font-weight:600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:10px;height:10px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                                            Belum Janji
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($tamu->kategori)
                                <span class="tag" style="background:{{ $tamu->kategori->warna }}22;color:{{ $tamu->kategori->warna }}">
                                    {{ $tamu->kategori->nama_kategori }}
                                </span>
                                @else<span style="color:var(--text-muted)">—</span>@endif
                            </td>
                            <td>
                                @if($tamu->pegawaiTujuan)
                                <div style="font-size:12px;font-weight:600">{{ $tamu->pegawaiTujuan->nama }}</div>
                                <div style="font-size:11px;color:var(--text-muted)">{{ $tamu->pegawaiTujuan->jabatan }}</div>
                                @else<span style="font-size:12px;color:var(--text-muted)">{{ $tamu->tujuan_kunjungan }}</span>@endif
                            </td>
                            <td>
                                @if($tamu->status === 'Menunggu')
                                    <span class="badge badge-menunggu">{{ $tamu->status }}</span>
                                @elseif($tamu->status === 'Sedang Ditemui')
                                    <span class="badge badge-ditemui">{{ $tamu->status }}</span>
                                @else
                                    <span class="badge badge-selesai">{{ $tamu->status }}</span>
                                @endif
                            </td>
                            <td style="font-size:12px;color:var(--text-muted);white-space:nowrap">
                                {{ $tamu->jam_masuk->format('H:i') }}
                                @if($tamu->jam_pulang)
                                    <br><span style="color:#94a3b8">({{ $tamu->durasi }})</span>
                                @endif
                            </td>
                            <td>
                                @if($tamu->wa_sent_at)
                                    <span title="WA terkirim {{ $tamu->wa_sent_at->format('H:i') }}" style="color:var(--green); display:inline-flex; align-items:center;" class="wa-sent">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                    </span>
                                @elseif($tamu->pegawaiTujuan)
                                    <span title="WA belum terkirim" style="color:var(--amber); display:inline-flex; align-items:center;" class="wa-pending">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                    </span>
                                @else
                                    <span style="color:var(--text-muted);font-size:11px">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    @if($tamu->status === 'Menunggu')
                                    <form method="POST" action="{{ route('admin.buku-tamu.status', $tamu) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="Sedang Ditemui">
                                        <button class="btn btn-blue btn-sm">Temui</button>
                                    </form>
                                    @elseif($tamu->status === 'Sedang Ditemui')
                                    <form method="POST" action="{{ route('admin.buku-tamu.status', $tamu) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="Selesai">
                                        <button class="btn btn-ghost btn-sm">Selesai</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:32px">Belum ada kunjungan hari ini</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination-info">Menampilkan {{ $kunjunganHariIni->firstItem() ?? 0 }}-{{ $kunjunganHariIni->lastItem() ?? 0 }} dari {{ $kunjunganHariIni->total() }} tamu</div>
                <div class="pagination">{{ $kunjunganHariIni->links() }}</div>
            </div>
        </div>
    </div>

    <div style="width:260px;flex-shrink:0">
        <div class="card" style="padding:20px">
            <h3 style="font-size:13px;font-weight:600;margin-bottom:16px">Kategori Pengunjung</h3>
            <div style="text-align:center;margin-bottom:16px">
                <div style="font-size:36px;font-weight:700">{{ $totalHari }}</div>
                <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px">Total</div>
            </div>
            @foreach($kategoriStats as $k)
            @if($k->total_hari_ini > 0)
            <div class="flex items-center gap-2 mb-4" style="justify-content:space-between">
                <div class="flex items-center gap-2">
                    <span style="width:10px;height:10px;border-radius:50%;background:{{ $k->warna }};display:inline-block;flex-shrink:0"></span>
                    <span style="font-size:12px">{{ $k->nama_kategori }}</span>
                </div>
                <div style="font-size:12px;color:#64748b">
                    {{ $k->total_hari_ini }}
                    @if($totalHari > 0)
                    ({{ round($k->total_hari_ini / $totalHari * 100) }}%)
                    @endif
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
