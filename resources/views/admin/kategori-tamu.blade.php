@extends('layouts.admin')
@section('title', 'Kategori Tamu')
@section('page-title', 'Kategori Tamu')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-size:18px;font-weight:700">Manajemen Kategori</h2>
        <p style="font-size:13px;color:#64748b;margin-top:2px">Kelola kategori tamu yang tersedia di form check-in</p>
    </div>
    <button onclick="document.getElementById('modal-tambah').classList.add('open')" class="btn btn-primary">
        + Tambah Kategori
    </button>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Warna</th>
                <th>Jumlah Tamu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $i => $k)
            <tr>
                <td style="color:#94a3b8;font-size:12px">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div class="flex items-center gap-2">
                        <span style="width:12px;height:12px;border-radius:50%;background:{{ $k->warna }};display:inline-block"></span>
                        <span style="font-weight:600;font-size:13px">{{ $k->nama_kategori }}</span>
                    </div>
                </td>
                <td><span class="tag" style="background:{{ $k->warna }}22;color:{{ $k->warna }}">{{ $k->warna }}</span></td>
                <td style="font-size:13px">{{ $k->tamu_count }} tamu</td>
                <td>
                    <div class="flex gap-2">
                        <button onclick="openEdit({{ $k->id }}, '{{ $k->nama_kategori }}', '{{ $k->warna }}')" class="btn btn-ghost btn-sm">Edit</button>
                        <form method="POST" action="{{ route('admin.kategori-tamu.destroy', $k) }}" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:32px">Belum ada kategori</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal-backdrop" id="modal-tambah">
    <div class="modal">
        <h3 class="modal-title">Tambah Kategori</h3>
        <form method="POST" action="{{ route('admin.kategori-tamu.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Wali Murid" required>
            </div>
            <div class="form-group">
                <label class="form-label">Warna</label>
                <div class="flex gap-2 items-center">
                    <input type="color" name="warna" value="#f97316" style="width:40px;height:36px;border:1px solid #e2e8f0;border-radius:6px;cursor:pointer">
                    <span style="font-size:12px;color:#64748b">Pilih warna label kategori</span>
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
        <h3 class="modal-title">Edit Kategori</h3>
        <form method="POST" id="form-edit" action="">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="edit-nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Warna</label>
                <input type="color" name="warna" id="edit-warna" style="width:40px;height:36px;border:1px solid #e2e8f0;border-radius:6px;cursor:pointer">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-edit').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
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
</script>
@endpush
@endsection
