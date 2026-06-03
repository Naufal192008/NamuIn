@extends('layouts.admin')
@section('title', 'Buku Tamu')
@section('page-title', 'Buku Tamu')

@section('content')
<div class="grid-2 mb-6">
    <div class="stat-card primary-border">
        <div class="stat-icon orange">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </div>
        <div class="stat-label">Tamu Menunggu</div>
        <div class="stat-value" style="color:var(--primary)">{{ $menunggu }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
        </div>
        <div class="stat-label">Total Hari Ini</div>
        <div class="stat-value">{{ $totalHari }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Kunjungan Hari Ini</h3>
        <div class="flex gap-2">
            <form method="GET" class="flex gap-2 items-center">
                <select name="status" class="form-control" style="width:auto;padding:6px 10px;font-size:12px" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Sedang Ditemui" {{ request('status') == 'Sedang Ditemui' ? 'selected' : '' }}>Sedang Ditemui</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </form>
            <button onclick="document.getElementById('modal-tambah').classList.add('open')" class="btn btn-primary btn-sm">
                + Tambah Manual
            </button>
        </div>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Nama Tamu</th>
                    <th>Kategori</th>
                    <th>Bertemu Dengan</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>WA</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kunjungan as $tamu)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px">{{ $tamu->nama_tamu }}</div>
                        <div style="font-size:11px;color:var(--text-muted)">{{ $tamu->instansi }}</div>
                        <div style="font-size:11px;color:var(--text-muted);display:flex;align-items:center;gap:4px;margin-top:2px">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:12px;height:12px;opacity:.7"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                            {{ $tamu->no_wa }}
                        </div>
                        <div style="margin-top:4px">
                            @if($tamu->sudah_janji)
                                <span class="badge" style="background:#EEF2FF; color:#4F46E5; border:1px solid #C7D2FE; font-size:9px; padding:1px 6px; border-radius:4px; display:inline-flex; align-items:center; gap:3px; font-weight:600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:10px;height:10px"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                    Ada Janji
                                </span>
                            @else
                                <span class="badge" style="background:#F4F4F5; color:#71717A; border:1px solid #E4E4E7; font-size:9px; padding:1px 6px; border-radius:4px; display:inline-flex; align-items:center; gap:3px; font-weight:600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:10px;height:10px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                                    Belum Janji
                                </span>
                            @endif
                        </div>
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
                        @else<span style="color:var(--text-muted)">—</span>@endif
                    </td>
                    <td style="font-size:12px;max-width:140px">{{ $tamu->tujuan_kunjungan }}</td>
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
                            <span title="WA terkirim {{ $tamu->wa_sent_at->format('H:i') }}" style="color:var(--green); display:inline-flex; align-items:center; cursor:default;" class="wa-sent">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:15px;height:15px"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            </span>
                        @elseif($tamu->pegawaiTujuan)
                            <span title="WA belum terkirim" style="color:var(--amber); display:inline-flex; align-items:center; cursor:default;" class="wa-pending">
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
                            <form method="POST" action="{{ route('admin.buku-tamu.destroy', $tamu) }}" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:40px">Belum ada kunjungan hari ini</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-info">Menampilkan {{ $kunjungan->firstItem() ?? 0 }}-{{ $kunjungan->lastItem() ?? 0 }} dari {{ $kunjungan->total() }} tamu</div>
        <div class="pagination">{{ $kunjungan->links() }}</div>
    </div>
</div>

<div class="modal-backdrop" id="modal-tambah">
    <div class="modal" style="max-width:520px">
        <h3 class="modal-title">Tambah Kunjungan Manual</h3>
        <form method="POST" action="{{ route('admin.buku-tamu.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_tamu" class="form-control" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Asal Instansi</label>
                    <input type="text" name="instansi" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">No. WhatsApp</label>
                    <input type="text" name="no_wa" class="form-control" required>
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Bertemu Dengan</label>
                    <select name="bertemu_dengan" class="form-control">
                        <option value="">Pilih Pegawai (opsional)</option>
                        @foreach($pegawais as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }} — {{ $p->jabatan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Tujuan Kunjungan</label>
                <input type="text" name="tujuan_kunjungan" class="form-control" required>
            </div>
            <div class="form-group" style="display:flex; align-items:center; gap:10px; margin: 10px 0 16px">
                <input type="checkbox" name="sudah_janji" id="modal_sudah_janji" value="1" style="width:16px; height:16px; accent-color:var(--primary); cursor:pointer">
                <label for="modal_sudah_janji" style="font-size:12px; font-weight:600; cursor:pointer; user-select:none; color:var(--text); text-transform:none; letter-spacing:0">Sudah memiliki janji temu sebelumnya</label>
            </div>
            <div class="form-group">
                <label class="form-label">Detail Keperluan</label>
                <textarea name="detail_keperluan" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-tambah').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.modal-backdrop').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});
</script>
@endpush
@endsection
