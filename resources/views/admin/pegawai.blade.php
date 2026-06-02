@extends('layouts.admin')
@section('title', 'Staf Sekolah — NamuIn')
@section('page-title', 'Staf Sekolah')

@push('styles')
<style>
    .staf-avatar{width:36px;height:36px;border-radius:50%;background:var(--primary);color:#fff;font-weight:700;font-size:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .nip-code{font-family:ui-monospace,SFMono-Regular,monospace;font-size:11px;color:var(--text-muted);letter-spacing:.3px}
    .dept-pill{display:inline-block;padding:2px 8px;border-radius:4px;background:#F4F4F5;color:#374151;font-size:11px;font-weight:600;border:1px solid var(--border)}
    .toggle-pill{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:600;border:none;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;transition:.12s}
    .toggle-pill.aktif{background:#DCFCE7;color:#15803D}
    .toggle-pill.aktif:hover{background:#BBF7D0}
    .toggle-pill.nonaktif{background:#F4F4F5;color:#71717A}
    .toggle-pill.nonaktif:hover{background:#E4E4E7}
    .toggle-dot{width:6px;height:6px;border-radius:50%;background:currentColor;flex-shrink:0}
    .search-wrap{position:relative}
    .search-wrap .search-icon{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none}
    .search-wrap .search-icon svg{width:15px;height:15px}
    .search-wrap input{padding-left:32px}
</style>
@endpush

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-family:'Bricolage Grotesque',sans-serif;font-size:20px;font-weight:800">Staf Sekolah</h2>
        <p style="font-size:13px;color:var(--text-muted);margin-top:2px">Kelola daftar staf yang dapat ditemui oleh tamu.</p>
    </div>
    <button onclick="document.getElementById('modal-tambah').classList.add('open')" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        Tambah Staf
    </button>
</div>

<div class="grid-3 mb-6">
    <div class="stat-card primary-border">
        <div class="stat-icon orange">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
        </div>
        <div class="stat-label">Total Staf</div>
        <div class="stat-value">{{ $pegawais->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </div>
        <div class="stat-label">Aktif</div>
        <div class="stat-value" style="color:var(--green)">{{ $pegawais->where('aktif', true)->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
        </div>
        <div class="stat-label">Total Kunjungan Ditangani</div>
        <div class="stat-value">{{ $pegawais->sum('tamu_count') }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Daftar Staf</h3>
        <div class="search-wrap">
            <span class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </span>
            <input type="text" id="search-staf" class="form-control" style="width:220px" placeholder="Cari nama, jabatan...">
        </div>
    </div>
    <div class="card-body">
        <table id="staf-table">
            <thead>
                <tr>
                    <th>Staf</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>WhatsApp</th>
                    <th>Kunjungan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pegawais as $p)
                <tr class="staf-row" data-search="{{ strtolower($p->nama . ' ' . $p->jabatan . ' ' . $p->departemen) }}">
                    <td>
                        <div class="flex items-center gap-2">
                            <div class="staf-avatar">{{ mb_substr($p->nama, 0, 1) }}</div>
                            <div>
                                <div style="font-weight:600;font-size:13px">{{ $p->nama }}</div>
                                @if($p->email)
                                <div style="font-size:11px;color:var(--text-muted)">{{ $p->email }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><span class="nip-code">{{ $p->nip ?? '—' }}</span></td>
                    <td style="font-size:13px;font-weight:500">{{ $p->jabatan }}</td>
                    <td>
                        @if($p->departemen)
                        <span class="dept-pill">{{ $p->departemen }}</span>
                        @else
                        <span style="color:var(--text-muted)">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center gap-1" style="font-size:12px;color:var(--text-muted)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px;flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
                            {{ $p->no_wa }}
                        </div>
                    </td>
                    <td>
                        <span style="font-weight:700;color:var(--primary);font-size:14px">{{ $p->tamu_count }}</span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.pegawai.toggle', $p) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="toggle-pill {{ $p->aktif ? 'aktif' : 'nonaktif' }}">
                                <span class="toggle-dot"></span>
                                {{ $p->aktif ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <button onclick="openEdit({{ $p->id }}, {{ json_encode($p) }})" class="btn btn-ghost btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg>
                            </button>
                            <form method="POST" action="{{ route('admin.pegawai.destroy', $p) }}" onsubmit="return confirm('Hapus {{ $p->nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;padding:48px;color:var(--text-muted)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:40px;height:40px;opacity:.2;margin:0 auto 10px;display:block"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                    Belum ada staf. Klik "Tambah Staf" untuk memulai.
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal-backdrop" id="modal-tambah">
    <div class="modal" style="max-width:520px">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Staf</h3>
            <button class="modal-close" onclick="document.getElementById('modal-tambah').classList.remove('open')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.pegawai.store') }}">
            @csrf
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color:var(--red)">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Drs. Ahmad Fauzi" required>
                </div>
                <div class="form-group">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control" placeholder="196501011990031001">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Jabatan <span style="color:var(--red)">*</span></label>
                    <input type="text" name="jabatan" class="form-control" placeholder="Kepala Sekolah" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Departemen / Bidang</label>
                    <input type="text" name="departemen" class="form-control" placeholder="Kurikulum">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp <span style="color:var(--red)">*</span></label>
                    <input type="text" name="no_wa" class="form-control" placeholder="081234567890" required>
                    <p style="font-size:11px;color:var(--text-muted);margin-top:4px">Notifikasi WA dikirim ke nomor ini.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@sekolah.sch.id">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('modal-tambah').classList.remove('open')" class="btn btn-ghost">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Staf</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal-backdrop" id="modal-edit">
    <div class="modal" style="max-width:520px">
        <div class="modal-header">
            <h3 class="modal-title">Edit Staf</h3>
            <button class="modal-close" onclick="document.getElementById('modal-edit').classList.remove('open')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form method="POST" id="form-edit">
            @csrf @method('PATCH')
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color:var(--red)">*</span></label>
                    <input type="text" name="nama" id="edit-nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" id="edit-nip" class="form-control">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Jabatan <span style="color:var(--red)">*</span></label>
                    <input type="text" name="jabatan" id="edit-jabatan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Departemen / Bidang</label>
                    <input type="text" name="departemen" id="edit-departemen" class="form-control">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp <span style="color:var(--red)">*</span></label>
                    <input type="text" name="no_wa" id="edit-no_wa" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="edit-email" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('modal-edit').classList.remove('open')" class="btn btn-ghost">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEdit(id, p) {
    document.getElementById('form-edit').action = `/admin/pegawai/${id}`;
    document.getElementById('edit-nama').value = p.nama || '';
    document.getElementById('edit-nip').value = p.nip || '';
    document.getElementById('edit-jabatan').value = p.jabatan || '';
    document.getElementById('edit-departemen').value = p.departemen || '';
    document.getElementById('edit-no_wa').value = p.no_wa || '';
    document.getElementById('edit-email').value = p.email || '';
    document.getElementById('modal-edit').classList.add('open');
}
document.getElementById('search-staf').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.staf-row').forEach(r => {
        r.style.display = r.dataset.search.includes(q) ? '' : 'none';
    });
});
document.querySelectorAll('.modal-backdrop').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});
</script>
@endpush
@endsection
