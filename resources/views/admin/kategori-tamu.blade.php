@extends('layouts.admin')
@section('title', 'Kategori Tamu — NamuIn')
@section('page-title', 'Kategori Tamu')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-family:'Bricolage Grotesque',sans-serif;font-size:20px;font-weight:800">Kategori Tamu</h2>
        <p style="font-size:13px;color:var(--text-muted);margin-top:2px">Kelola kategori tamu yang tersedia di form check-in.</p>
    </div>
    <button onclick="document.getElementById('modal-tambah').classList.add('open')" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        Tambah Kategori
    </button>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th style="width:40px">#</th>
                <th>Nama Kategori</th>
                <th>Label</th>
                <th>Jumlah Tamu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $i => $k)
            <tr>
                <td style="color:var(--text-muted);font-size:12px;font-variant-numeric:tabular-nums">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div class="flex items-center gap-2">
                        <span style="width:10px;height:10px;border-radius:50%;background:{{ $k->warna }};display:inline-block;flex-shrink:0"></span>
                        <span style="font-weight:600;font-size:13px">{{ $k->nama_kategori }}</span>
                    </div>
                </td>
                <td>
                    <span class="tag" style="background:{{ $k->warna }}22;color:{{ $k->warna }};font-family:monospace">{{ $k->warna }}</span>
                </td>
                <td>
                    <span style="font-weight:700;color:var(--primary)">{{ $k->tamu_count }}</span>
                    <span style="font-size:12px;color:var(--text-muted)"> tamu</span>
                </td>
                <td>
                    <div class="flex gap-2">
                        <button onclick="openEdit({{ $k->id }}, '{{ $k->nama_kategori }}', '{{ $k->warna }}')" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg>
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.kategori-tamu.destroy', $k) }}" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--text-muted);padding:40px">
                <div style="margin-bottom:8px">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:40px;height:40px;opacity:.3;margin:0 auto;display:block"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /></svg>
                </div>
                Belum ada kategori. Klik "Tambah Kategori" untuk memulai.
            </td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="modal-tambah">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Kategori</h3>
            <button class="modal-close" onclick="document.getElementById('modal-tambah').classList.remove('open')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.kategori-tamu.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Wali Murid" required>
            </div>
            <div class="form-group">
                <label class="form-label">Warna Label</label>
                <div class="flex gap-3 items-center">
                    <input type="color" name="warna" value="#f97316" style="width:44px;height:38px;border:1.5px solid var(--border);border-radius:7px;cursor:pointer;padding:2px">
                    <span style="font-size:12px;color:var(--text-muted)">Warna ini tampil di badge kategori tamu.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-tambah').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-backdrop" id="modal-edit">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Edit Kategori</h3>
            <button class="modal-close" onclick="document.getElementById('modal-edit').classList.remove('open')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form method="POST" id="form-edit" action="">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="edit-nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Warna Label</label>
                <input type="color" name="warna" id="edit-warna" style="width:44px;height:38px;border:1.5px solid var(--border);border-radius:7px;cursor:pointer;padding:2px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-edit').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEdit(id, nama, warna) {
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-warna').value = warna;
    document.getElementById('form-edit').action = '/admin/kategori-tamu/' + id;
    document.getElementById('modal-edit').classList.add('open');
}
document.querySelectorAll('.modal-backdrop').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});
</script>
@endpush
@endsection
