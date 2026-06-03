@extends('layouts.admin')
@section('title', 'Persetujuan Janji Temu — NamuIn')
@section('page-title', 'Janji Temu')

@push('styles')
<style>
    .grid-5 {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
    }
    @media (max-width: 1024px) {
        .grid-5 {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 640px) {
        .grid-5 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 style="font-family:'Bricolage Grotesque',sans-serif;font-size:20px;font-weight:800">Persetujuan Janji Temu</h2>
        <p style="font-size:13px;color:var(--text-muted);margin-top:2px">Kelola dan proses pengajuan pre-booking janji tamu sebelum mereka tiba.</p>
    </div>
</div>

{{-- BENTO STATS ROW --}}
<div class="grid-5 mb-6">
    <div class="stat-card primary-border" style="padding: 16px 20px;">
        <div class="stat-icon orange" style="margin-bottom:10px; width:32px; height:32px;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px; height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg></div>
        <div class="stat-label" style="font-size:9.5px;">Total Pengajuan</div>
        <div class="stat-value" style="font-size:26px; font-variant-numeric: tabular-nums;">{{ $totalCount }}</div>
    </div>
    <div class="stat-card" style="padding: 16px 20px;">
        <div class="stat-icon purple" style="margin-bottom:10px; width:32px; height:32px;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px; height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
        <div class="stat-label" style="font-size:9.5px; color:#B45309">Diajukan</div>
        <div class="stat-value" style="font-size:26px; font-variant-numeric: tabular-nums; color:#B45309">{{ $diajukanCount }}</div>
    </div>
    <div class="stat-card" style="padding: 16px 20px;">
        <div class="stat-icon green" style="margin-bottom:10px; width:32px; height:32px;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px; height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg></div>
        <div class="stat-label" style="font-size:9.5px; color:var(--green)">Disetujui</div>
        <div class="stat-value" style="font-size:26px; font-variant-numeric: tabular-nums; color:var(--green)">{{ $disetujuiCount }}</div>
    </div>
    <div class="stat-card" style="padding: 16px 20px;">
        <div class="stat-icon red" style="margin-bottom:10px; width:32px; height:32px; background:var(--red-bg); color:var(--red)"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px; height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
        <div class="stat-label" style="font-size:9.5px; color:var(--red)">Dibatalkan</div>
        <div class="stat-value" style="font-size:26px; font-variant-numeric: tabular-nums; color:var(--red)">{{ $dibatalkanCount }}</div>
    </div>
    <div class="stat-card" style="padding: 16px 20px;">
        <div class="stat-icon blue" style="margin-bottom:10px; width:32px; height:32px;"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width:16px; height:16px;"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235A8.91 8.91 0 009 20.25a8.91 8.91 0 005-1.015m-10 0A8.968 8.968 0 004 18c0-2.27 1.34-4.227 3.266-5.127m0 0A9.037 9.037 0 019 12.75c1.077 0 2.102.19 3.051.536M4 19.235a9.722 9.722 0 005.001.215M9 19.235v.004H9" /></svg></div>
        <div class="stat-label" style="font-size:9.5px; color:var(--blue)">Hadir/Check-in</div>
        <div class="stat-value" style="font-size:26px; font-variant-numeric: tabular-nums; color:var(--blue)">{{ $checkinCount }}</div>
    </div>
</div>

{{-- SEARCH & FILTER ROW --}}
<div class="card mb-6" style="padding:16px 20px">
    <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex gap-3 items-center">
        <div class="form-group flex-1" style="margin-bottom:0">
            <div class="input-icon-wrap">
                <span class="icon-left">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" /></svg>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Cari nama tamu, instansi, atau kode booking..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="form-group" style="margin-bottom:0; width:170px">
            <select name="status" class="form-control" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Diajukan" {{ request('status') === 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="Disetujui" {{ request('status') === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Dibatalkan" {{ request('status') === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                <option value="Checkin" {{ request('status') === 'Checkin' ? 'selected' : '' }}>Hadir/Checkin</option>
            </select>
        </div>
        <div class="form-group" style="margin-bottom:0; width:170px">
            <input type="date" name="date" class="form-control" value="{{ request('date') }}" onchange="this.form.submit()">
        </div>
        <button type="submit" class="btn btn-secondary">Filter</button>
        @if(request()->anyFilled(['search', 'status', 'date']))
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-ghost">Reset</a>
        @endif
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Tamu</th>
                <th>Bertemu Dengan</th>
                <th>Waktu Janji</th>
                <th>Status</th>
                <th>Catatan Staf</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $i => $b)
            <tr>
                <td style="font-family:ui-monospace,SFMono-Regular,Consolas,monospace; font-weight:700; color:var(--primary); font-size:13px; font-variant-numeric: tabular-nums;">
                    {{ $b->booking_code }}
                </td>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="profile-avatar" style="width:30px; height:30px; font-size:11px; flex-shrink:0; font-weight:800; background:var(--primary); color:#fff; border:1px solid rgba(255,255,255,0.15)">
                            {{ strtoupper(substr($b->nama_tamu, 0, 1)) }}
                        </div>
                        <div>
                            <span style="font-weight:700;font-size:13px">{{ $b->nama_tamu }}</span>
                            <div style="font-size:11px;color:var(--text-muted)">{{ $b->instansi }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="font-weight:600;font-size:13px">{{ $b->pegawaiTujuan ? $b->pegawaiTujuan->nama : '-' }}</div>
                    <div style="font-size:11px;color:var(--text-muted)">{{ $b->pegawaiTujuan ? $b->pegawaiTujuan->jabatan : '-' }}</div>
                </td>
                <td style="font-size:12px;color:var(--text-muted);font-variant-numeric:tabular-nums">
                    <div>{{ $b->tanggal_booking->format('d/m/Y') }}</div>
                    <div style="font-weight:600;color:var(--text);margin-top:2px">{{ $b->jam_booking }} WIB</div>
                </td>
                <td>
                    @if($b->status === 'Diajukan')
                        <span class="badge badge-menunggu"><span class="badge-dot"></span>Diajukan</span>
                    @elseif($b->status === 'Disetujui')
                        <span class="badge badge-selesai" style="background:#DCFCE7; color:#16A34A"><span class="badge-dot"></span>Disetujui</span>
                    @elseif($b->status === 'Dibatalkan')
                        <span class="badge badge-danger" style="background:var(--red-bg); color:var(--red)"><span class="badge-dot"></span>Dibatalkan</span>
                    @elseif($b->status === 'Checkin')
                        <span class="badge badge-ditemui" style="background:#E0F2FE; color:#0369A1"><span class="badge-dot"></span>Hadir/Check-in</span>
                    @endif
                </td>
                <td style="font-size:12px;color:var(--text-muted);max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="{{ $b->catatan_staf ?: '-' }}">
                    {{ $b->catatan_staf ?: '-' }}
                </td>
                <td>
                    @if($b->status === 'Diajukan')
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.bookings.approve', $b) }}">
                            @csrf
                            <button type="submit" class="btn btn-blue btn-sm" style="background:#DCFCE7; color:#16A34A; border-color:#BBF7D0" title="Setujui Janji Temu">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                Setujui
                            </button>
                        </form>
                        <button onclick="openReject({{ $b->id }}, '{{ $b->nama_tamu }}')" class="btn btn-danger btn-sm" title="Tolak Janji Temu">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                            Tolak
                        </button>
                    </div>
                    @else
                    <span style="font-size:11px;color:var(--text-muted)">Selesai diproses</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:var(--text-muted);padding:40px">
                <div style="margin-bottom:8px">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" style="width:40px;height:40px;opacity:.3;margin:0 auto;display:block"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                </div>
                Tidak ditemukan janji temu yang sesuai.
            </td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="pagination-info">
        Menampilkan {{ $bookings->firstItem() ?? 0 }}-{{ $bookings->lastItem() ?? 0 }} dari {{ $bookings->total() }} hasil
    </div>
    <div class="pagination">
        {{ $bookings->links() }}
    </div>
</div>

{{-- MODAL TOLAK/BATALKAN --}}
<div class="modal-backdrop" id="modal-reject">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Tolak Janji Temu</h3>
            <button class="modal-close" onclick="document.getElementById('modal-reject').classList.remove('open')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div style="font-size:13px; color:var(--text-muted); margin-bottom:16px;">
            Anda akan menolak pengajuan janji temu dari <strong id="reject-guest-name" style="color:var(--text)">-</strong>. Notifikasi pembatalan akan dikirim via WhatsApp.
        </div>
        <form method="POST" id="form-reject" action="">
            @csrf
            <div class="form-group">
                <label class="form-label">Alasan Penolakan</label>
                <textarea name="catatan_staf" class="form-control" placeholder="Contoh: Maaf, staf bersangkutan sedang dinas luar kota pada tanggal tersebut." style="height:100px; resize:none" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-reject').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary" style="background:var(--red); border-color:var(--red)">Tolak Janji Temu</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openReject(id, name) {
    document.getElementById('reject-guest-name').textContent = name;
    document.getElementById('form-reject').action = '/admin/bookings/' + id + '/reject';
    document.getElementById('modal-reject').classList.add('open');
}
document.querySelectorAll('.modal-backdrop').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});
</script>
@endpush
@endsection
