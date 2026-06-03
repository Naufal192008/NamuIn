@extends('layouts.admin')
@section('title', 'Simulator WhatsApp — NamuIn')
@section('page-title', 'Simulator WhatsApp')

@section('content')
<div class="mb-6">
    <h2 style="font-family:'Bricolage Grotesque',sans-serif;font-size:20px;font-weight:800">Simulator WhatsApp Dua Arah</h2>
    <p style="font-size:13px;color:var(--text-muted);margin-top:2px">Simulasikan respon WhatsApp dari Staf Sekolah (Pegawai) ke sistem NamuIn.</p>
</div>

<div class="alert alert-success" style="background:var(--primary-bg); color:var(--primary); border-color:rgba(255,107,0,0.2); margin-bottom:24px">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width:16px;height:16px"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" /></svg>
    <div>
        <strong>Petunjuk Penggunaan:</strong> Halaman ini mensimulasikan webhook dari Fonnte ketika Staf Sekolah membalas pesan notifikasi WhatsApp. Ini memungkinkan pengujian dua-arah berjalan di server lokal secara offline.
    </div>
</div>

@if(session('sim_response'))
<div class="card mb-6" style="padding:16px; background:#fafafa; border:1.5px dashed var(--border)">
    <h4 style="font-size:12px; font-weight:700; color:var(--text-muted); text-transform:uppercase; margin-bottom:8px">Hasil Simulasi Webhook</h4>
    <div style="font-size:12px; font-family:monospace; background:#fff; padding:12px; border-radius:6px; border:1px solid var(--border); overflow-x:auto">
        <div style="margin-bottom:6px"><strong>HTTP Status:</strong> <span class="badge {{ session('sim_status') == 200 ? 'badge-selesai' : 'badge-menunggu' }}">{{ session('sim_status') }}</span></div>
        <pre>{{ json_encode(session('sim_response'), JSON_PRETTY_PRINT) }}</pre>
    </div>
</div>
@endif

<div class="grid-2">
    <!-- PANEL KIRI: KIRIM SIMULASI -->
    <div class="card">
        <div class="card-header">
            <h3>Kirim Balasan Staf</h3>
        </div>
        <div class="card-body" style="padding:20px">
            <form method="POST" action="{{ route('admin.whatsapp-simulator.post') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Staf Sekolah (Pengirim Pesan)</label>
                    <select name="sender" id="sender-select" class="form-control" required onchange="updateStaffInfo()">
                        <option value="">-- Pilih Staf Pengirim --</option>
                        @foreach($pegawais as $p)
                        <option value="{{ $p->no_wa }}" data-id="{{ $p->id }}" data-jabatan="{{ $p->jabatan }}" data-dept="{{ $p->departemen }}">
                            {{ $p->nama }} ({{ $p->no_wa }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div id="staff-guest-info" class="mb-4" style="display:none; padding:12px; border-radius:8px; background:rgba(0,0,0,0.02); border:1px solid var(--border); font-size:12px">
                    <span style="color:var(--text-muted)">Info Kunjungan Aktif:</span>
                    <div id="active-guest-text" style="font-weight:600; margin-top:4px">Tidak ada tamu yang sedang menunggu staf ini.</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Isi Pesan WhatsApp</label>
                    <input type="text" name="message" id="message-input" class="form-control" placeholder="Contoh: OK atau 1" required>
                    <p style="font-size:11px; color:var(--text-muted); margin-top:4px">
                        Ketik respon balasan: <strong>1</strong> (OK), <strong>2</strong> (TUNDA), atau <strong>3</strong> (SIBUK).
                    </p>
                </div>

                <div class="flex gap-2 mb-4">
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setMsg('1')">1 (Temui Tamu)</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setMsg('2')">2 (Tunda / Tunggu)</button>
                    <button type="button" class="btn btn-ghost btn-sm" onclick="setMsg('3')">3 (Sibuk / Batal)</button>
                </div>

                <button type="submit" class="btn btn-secondary" style="width:100%">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" /></svg>
                    Kirim Simulasi Webhook
                </button>
            </form>
        </div>
    </div>

    <!-- PANEL KANAN: STATUS KUNJUNGAN AKTIF & BOOKING -->
    <div style="display:flex; flex-direction:column; gap:24px">
        <div class="card">
            <div class="card-header">
                <h3>Daftar Tamu Aktif (Menunggu / Ditemui)</h3>
            </div>
            <div class="card-body">
                <table style="font-size:12px">
                    <thead>
                        <tr>
                            <th>Tamu / Instansi</th>
                            <th>Bertemu Staf</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeGuests as $t)
                        <tr class="guest-row" data-staff-id="{{ $t->bertemu_dengan }}">
                            <td>
                                <div style="font-weight:600">{{ $t->nama_tamu }}</div>
                                <div style="font-size:10px; color:var(--text-muted)">{{ $t->instansi }}</div>
                            </td>
                            <td>
                                @if($t->pegawaiTujuan)
                                <div>{{ $t->pegawaiTujuan->nama }}</div>
                                <div style="font-size:10px; color:var(--text-muted)">{{ $t->pegawaiTujuan->jabatan }}</div>
                                @else
                                <div style="color:var(--text-muted)">—</div>
                                @endif
                            </td>
                            <td>
                                @if($t->status === 'Menunggu')
                                    <span class="badge badge-menunggu">{{ $t->status }}</span>
                                @elseif($t->status === 'Sedang Ditemui')
                                    <span class="badge badge-ditemui">Ditemui</span>
                                @else
                                    <span class="badge badge-selesai">{{ $t->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align:center; color:var(--text-muted); padding:32px">Tidak ada tamu yang sedang aktif saat ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Daftar Pre-Booking (Menunggu Persetujuan)</h3>
            </div>
            <div class="card-body">
                <table style="font-size:12px">
                    <thead>
                        <tr>
                            <th>Tamu / Kode</th>
                            <th>Bertemu Staf</th>
                            <th>Simulasi Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeBookings as $b)
                        <tr>
                            <td>
                                <div style="font-weight:600">{{ $b->nama_tamu }}</div>
                                <div style="font-family:monospace; font-weight:700; color:var(--primary)">{{ $b->booking_code }}</div>
                            </td>
                            <td>
                                @if($b->pegawaiTujuan)
                                <div>{{ $b->pegawaiTujuan->nama }}</div>
                                <div style="font-size:10px; color:var(--text-muted)">{{ $b->pegawaiTujuan->no_wa }}</div>
                                @else
                                <div style="color:var(--text-muted)">—</div>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <button type="button" class="btn btn-ghost btn-sm" onclick="simulateBookingAction('{{ $b->pegawaiTujuan?->no_wa }}', 'SETUJU {{ $b->booking_code }}')">Setuju</button>
                                    <button type="button" class="btn btn-ghost btn-sm" onclick="simulateBookingAction('{{ $b->pegawaiTujuan?->no_wa }}', 'BATAL {{ $b->booking_code }}')">Batal</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" style="text-align:center; color:var(--text-muted); padding:32px">Tidak ada pre-booking pending saat ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const activeGuests = @json($activeGuests);

    function setMsg(val) {
        document.getElementById('message-input').value = val;
    }

    function simulateBookingAction(senderPhone, msg) {
        if (!senderPhone) return;
        const select = document.getElementById('sender-select');
        select.value = senderPhone;
        updateStaffInfo();
        document.getElementById('message-input').value = msg;
    }

    function updateStaffInfo() {
        const select = document.getElementById('sender-select');
        const selectedOption = select.options[select.selectedIndex];
        const infoDiv = document.getElementById('staff-guest-info');
        const infoText = document.getElementById('active-guest-text');

        if (!select.value) {
            infoDiv.style.display = 'none';
            return;
        }

        infoDiv.style.display = 'block';
        const staffId = parseInt(selectedOption.getAttribute('data-id'));
        
        // Find guest for this staff
        const guest = activeGuests.find(g => g.bertemu_dengan === staffId);

        if (guest) {
            infoText.innerHTML = `<span style="color:var(--primary)">👤 ${guest.nama_tamu}</span> dari ${guest.instansi} <br><span style="font-size:10px;color:var(--text-muted)">Status saat ini: <strong>${guest.status}</strong></span>`;
        } else {
            infoText.innerHTML = `<span style="color:var(--text-muted)">❌ Tidak ada tamu aktif yang mencari staf ini.</span>`;
        }
    }
</script>
@endsection
