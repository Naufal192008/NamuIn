@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Buku Tamu')

@section('content')
<div class="grid-3 mb-6">
    <div class="stat-card primary-border">
        <div class="stat-label">Tamu Menunggu <span>⏳</span></div>
        <div class="stat-value" style="color:var(--primary)">{{ $menunggu }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Sedang Ditemui <span>💬</span></div>
        <div class="stat-value" style="color:var(--tertiary)">{{ $ditemui }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Hari Ini <span>👥</span></div>
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
                                    <span title="WA terkirim {{ $tamu->wa_sent_at->format('H:i') }}" style="font-size:15px">✅</span>
                                @elseif($tamu->pegawaiTujuan)
                                    <span title="WA belum terkirim" style="font-size:15px">⏳</span>
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
                                        <button class="btn btn-tertiary btn-sm">Temui</button>
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
