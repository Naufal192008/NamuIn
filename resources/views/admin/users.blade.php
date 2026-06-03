@extends('layouts.admin')
@section('title', 'Kelola Pengguna — NamuIn')
@section('page-title', 'Kelola Pengguna')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-family:'Bricolage Grotesque',sans-serif;font-size:20px;font-weight:800">Manajemen Pengguna</h2>
        <p style="font-size:13px;color:var(--text-muted);margin-top:2px">Kelola semua pengguna sistem (Admin dan Resepsionis).</p>
    </div>
    <button onclick="document.getElementById('modal-tambah').classList.add('open')" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
        Tambah Pengguna
    </button>
</div>

{{-- BENTO STATS ROW --}}
<div class="grid-3 mb-6">
    <div class="stat-card primary-border">
        <div class="stat-icon orange">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
        </div>
        <div class="stat-label">Total Pengguna</div>
        <div class="stat-value" style="font-variant-numeric: tabular-nums;">{{ $totalCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
        </div>
        <div class="stat-label">Administrator</div>
        <div class="stat-value" style="font-variant-numeric: tabular-nums;">{{ $adminCount }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
        </div>
        <div class="stat-label">Resepsionis</div>
        <div class="stat-value" style="font-variant-numeric: tabular-nums;">{{ $receptionistCount }}</div>
    </div>
</div>

{{-- SEARCH & FILTER ROW --}}
<div class="card mb-6" style="padding:16px 20px">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-3 items-center">
        <div class="form-group flex-1" style="margin-bottom:0">
            <div class="input-icon-wrap">
                <span class="icon-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" /></svg>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama atau email..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="form-group" style="margin-bottom:0; width:200px">
            <select name="role" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Peran</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="receptionist" {{ request('role') === 'receptionist' ? 'selected' : '' }}>Resepsionis</option>
            </select>
        </div>
        <button type="submit" class="btn btn-secondary">Cari</button>
        @if(request()->anyFilled(['search', 'role']))
            <a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Reset</a>
        @endif
    </form>
</div>

@if ($errors->any())
<div class="alert alert-error">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
    <div style="display:flex; flex-direction:column; gap:2px">
        <span style="font-weight:700">Terjadi kesalahan input:</span>
        <ul style="padding-left:16px; margin:0; font-size:12px">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr>
                <th style="width:40px">#</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Peran</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $u)
            <tr>
                <td style="color:var(--text-muted);font-size:12px;font-variant-numeric:tabular-nums">
                    {{ str_pad(($users->currentPage() - 1) * $users->perPage() + $i + 1, 2, '0', STR_PAD_LEFT) }}
                </td>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="profile-avatar" style="width:30px; height:30px; font-size:11px; flex-shrink:0; font-weight:800; background: {{ $u->role === 'admin' ? 'var(--secondary)' : 'var(--primary)' }}; color:#fff; border:1px solid rgba(255,255,255,0.15)">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>
                        <div>
                            <span style="font-weight:700;font-size:13px">{{ $u->name }}</span>
                            @if(auth()->id() === $u->id)
                                <span style="font-size:10px; font-weight:700; background:#E0F2FE; color:#0369A1; padding:2px 6px; border-radius:4px; margin-left:4px">Anda</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="font-size:13px;color:var(--text-muted)">{{ $u->email }}</td>
                <td>
                    @if($u->role === 'admin')
                        <span class="tag" style="background:rgba(9, 9, 11, 0.05);color:var(--secondary);font-size:11px;font-weight:700;border:1px solid rgba(9, 9, 11, 0.1)">Administrator</span>
                    @else
                        <span class="tag" style="background:rgba(255, 107, 0, 0.06);color:var(--primary);font-size:11px;font-weight:700;border:1px solid rgba(255, 107, 0, 0.12)">Resepsionis</span>
                    @endif
                </td>
                <td style="font-size:12px;color:var(--text-muted);font-variant-numeric:tabular-nums">
                    {{ $u->created_at->format('d/m/Y H:i') }}
                </td>
                <td>
                    <div class="flex gap-2">
                        <button onclick="openEdit({{ $u->id }}, '{{ $u->name }}', '{{ $u->email }}', '{{ $u->role }}')" class="btn btn-ghost btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg>
                            Edit
                        </button>
                        @if(auth()->id() !== $u->id)
                        <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--text-muted);padding:40px">
                <div style="margin-bottom:8px">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:40px;height:40px;opacity:.3;margin:0 auto;display:block"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
                </div>
                Tidak ditemukan pengguna yang sesuai dengan kriteria pencarian.
            </td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-info">
        Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} hasil
    </div>
    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal-backdrop" id="modal-tambah">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Pengguna</h3>
            <button class="modal-close" onclick="document.getElementById('modal-tambah').classList.remove('open')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Contoh: budi@school.sch.id" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="form-group">
                <label class="form-label">Peran (Role)</label>
                <select name="role" class="form-control" required>
                    <option value="receptionist" selected>Resepsionis</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-tambah').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal-backdrop" id="modal-edit">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Edit Pengguna</h3>
            <button class="modal-close" onclick="document.getElementById('modal-edit').classList.remove('open')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <form method="POST" id="form-edit" action="">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="edit-name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="edit-email" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password Baru <span style="font-weight:400;text-transform:none;color:var(--text-muted)">(opsional)</span></label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>
            <div class="form-group">
                <label class="form-label">Peran (Role)</label>
                <select name="role" id="edit-role" class="form-control" required>
                    <option value="receptionist">Resepsionis</option>
                    <option value="admin">Administrator</option>
                </select>
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
function openEdit(id, name, email, role) {
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-role').value = role;
    document.getElementById('form-edit').action = '/admin/users/' + id;
    document.getElementById('modal-edit').classList.add('open');
}
document.querySelectorAll('.modal-backdrop').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});
</script>
@endpush
@endsection
