@extends('layouts.admin')
@section('title', 'Buku Tamu')
@section('page-title', 'Buku Tamu')

@section('content')
<div class="grid-2 mb-6">
    <div class="stat-card">
        <div class="stat-label">Tamu Menunggu <span>⏳</span></div>
        <div class="stat-value">{{ $menunggu }}</div>
    </div>
    <div class="stat-card orange-border">
        <div class="stat-label" style="color:#f97316">Total Hari Ini <span>👥</span></div>
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
                + Tambah Kunjungan
            </button>
        </div>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Nama Tamu</th>
                    <th>Instansi / Kategori</th>
                    <th>Tujuan</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kunjungan as $tamu)
                <tr>
                    <td>
                        <div style="font-weight:600;font-size:13px">{{ $tamu->nama_tamu }}</div>
                        <div style="font-size:11px;color:#64748b">{{ $tamu->instansi }}</div>
                    </td>
                    <td>
                        @if($tamu->kategori)
                        <span class="tag" style="background:{{ $tamu->kategori->warna }}22;color:{{ $tamu->kategori->warna }}">
                            {{ $tamu->kategori->nama_kategori }}
                        </span>
                        @endif
                    </td>
                    <td style="font-size:13px">{{ $tamu->tujuan_kunjungan }}</td>
                    <td>
                        @if($tamu->status === 'Menunggu')
                            <span class="badge badge-menunggu">{{ $tamu->status }}</span>
                        @elseif($tamu->status === 'Sedang Ditemui')
                            <span class="badge badge-ditemui">{{ $tamu->status }}</span>
                        @else
                            <span class="badge badge-selesai">{{ $tamu->status }}</span>
                        @endif
                    </td>
                    <td style="font-size:12px;color:#64748b;white-space:nowrap">
                        {{ $tamu->jam_masuk->format('H:i') }}
                        @if($tamu->jam_pulang)
                            <br><span style="color:#94a3b8">(dur: {{ $tamu->durasi }})</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex gap-2">
                            @if($tamu->status === 'Menunggu')
                            <form method="POST" action="{{ route('admin.buku-tamu.status', $tamu) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Sedang Ditemui">
                                <button class="btn btn-ghost btn-sm">Temui</button>
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
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:#94a3b8;padding:32px">Belum ada kunjungan hari ini</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-info">Menampilkan {{ $kunjungan->firstItem() ?? 0 }}-{{ $kunjungan->lastItem() ?? 0 }} dari {{ $kunjungan->total() }} tamu</div>
        <div class="pagination">{{ $kunjungan->links() }}</div>
    </div>
</div>

<div class="modal-backdrop" id="modal-tambah">
    <div class="modal">
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
                <label class="form-label">Tujuan Kunjungan</label>
                <input type="text" name="tujuan_kunjungan" class="form-control" required>
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
@endsection
