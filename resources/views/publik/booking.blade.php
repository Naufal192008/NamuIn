<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NamuIn — Pre-Booking Janji Temu</title>
    <meta name="description" content="Form pre-booking janji temu NamuIn.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        *:focus { outline: none !important; }
        :root {
            --primary: #FF6B00;
            --primary-dark: #E55F00;
            --secondary: #09090B;
            --neutral: #71717A;
            --text: #09090B;
            --muted: #71717A;
            --border: #E4E4E7;
            --bg: #F4F4F5;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            background-image: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.7) 0%, rgba(244,244,245,0.7) 100%), url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='2' cy='2' r='1' fill='rgba(9,9,11,0.03)'/%3E%3C/svg%3E");
            background-repeat: repeat;
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ─── TOPBAR ─── */
        .topbar {
            background: #fff;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 10;
        }
        .logo { display: flex; align-items: center; gap: 8px; text-decoration: none; }
        .logo-box {
            width: 28px; height: 28px; border-radius: 7px;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
        }
        .logo-box svg { width: 14px; height: 14px; color: #fff; }
        .logo-text { font-family: 'Bricolage Grotesque', sans-serif; font-size: 17px; font-weight: 800; color: var(--text); }
        .topbar-time { font-size: 12px; font-weight: 600; color: var(--muted); font-variant-numeric: tabular-nums; }

        /* ─── MAIN LAYOUT ─── */
        .page-body {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
        }

        .form-wrap { max-width: 560px; width: 100%; margin: 0 auto; }
        .hero { text-align: center; margin-bottom: 28px; }
        .hero h1 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 32px; font-weight: 800; color: var(--text); margin-bottom: 6px; letter-spacing: -0.8px; line-height: 1.1; }
        .hero p { font-size: 14px; color: var(--muted); font-weight: 500; }

        .form-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 20px 40px -15px rgba(9, 9, 11, 0.05);
        }

        .form-group { margin-bottom: 18px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 500px) {
            .form-row { grid-template-columns: 1fr; gap: 0; }
        }
        .form-label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--muted); margin-bottom: 7px; }
        .form-label.required::after { content: ' *'; color: var(--primary); }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            background: #FAFAFA;
            transition: all 0.15s ease-in-out;
            outline: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .form-control:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.08);
        }
        .form-control.error { border-color: #DC2626; }
        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2371717A' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }
        .phone-wrap { display: flex; align-items: stretch; }
        .phone-prefix { display: flex; align-items: center; padding: 0 14px; background: #F4F4F5; border: 1.5px solid var(--border); border-right: none; border-radius: 10px 0 0 10px; font-size: 14px; color: var(--muted); font-weight: 600; }
        .phone-wrap .form-control { border-radius: 0 10px 10px 0; }
        textarea.form-control { resize: none; min-height: 90px; }
        .form-error { font-size: 12px; color: #DC2626; margin-top: 5px; }

        .divider { display: flex; align-items: center; gap: 12px; margin: 8px 0 20px; }
        .divider hr { flex: 1; border: none; border-top: 1px solid var(--border); }
        .divider span { font-size: 11px; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }

        .ts-wrapper .ts-control { border: 1.5px solid var(--border) !important; border-radius: 8px !important; font-family: 'Plus Jakarta Sans', sans-serif !important; font-size: 14px !important; padding: 8px 12px !important; box-shadow: none !important; min-height: 42px !important; }
        .ts-wrapper.focus .ts-control { border-color: var(--primary) !important; box-shadow: 0 0 0 3px rgba(255,107,0,.1) !important; }
        .ts-wrapper .ts-control input { font-family: 'Plus Jakarta Sans', sans-serif !important; font-size: 14px !important; }
        .ts-dropdown { border: 1.5px solid var(--border) !important; border-radius: 8px !important; box-shadow: 0 8px 24px rgba(0,0,0,.1) !important; font-family: 'Plus Jakarta Sans', sans-serif !important; }
        .ts-dropdown .option { padding: 10px 14px !important; font-size: 13px !important; }
        .ts-dropdown .option:hover, .ts-dropdown .option.active { background: rgba(255,107,0,.08) !important; color: var(--primary) !important; }
        .ts-dropdown .option .job { font-size: 11px; color: var(--muted); margin-top: 1px; }

        .staf-card { background: #F4F4F5; border: 1.5px solid var(--border); border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; gap: 10px; margin-top: 8px; }
        .staf-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: #fff; font-weight: 700; font-size: 13px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .staf-name { font-weight: 700; font-size: 13px; }
        .staf-job { font-size: 11px; color: var(--muted); }

        .btn-submit { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 13px; border: none; border-radius: 8px; background: var(--secondary); color: #fff; font-size: 14px; font-weight: 700; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; margin-top: 24px; transition: .15s cubic-bezier(0.16, 1, 0.3, 1); }
        .btn-submit:hover { background: #27272A; }
        .btn-submit:active { transform: translateY(0.5px) scale(0.985); }
        .btn-submit svg { width: 16px; height: 16px; }
        .btn-submit .arrow { background: var(--primary); width: 28px; height: 28px; border-radius: 5px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .btn-submit .arrow svg { width: 14px; height: 14px; }

        /* HONEYPOT */
        .hp-field {
            position: absolute;
            left: -9999px;
            top: -9999px;
            width: 1px;
            height: 1px;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
        }

        /* SUCCESS STATE */
        .success-wrap { text-align: center; padding: 48px 20px; }
        .success-icon {
            width: 72px; height: 72px; border-radius: 50%;
            background: #DCFCE7;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }
        .success-icon svg { width: 36px; height: 36px; color: #16A34A; }
        .success-wrap h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 22px; font-weight: 800; margin-bottom: 8px; color: #14532D; }
        .success-wrap p { color: var(--muted); font-size: 14px; line-height: 1.6; }
        .wa-info { display: inline-flex; align-items: center; gap: 6px; margin-top: 12px; background: #DCFCE7; border: 1px solid #BBF7D0; border-radius: 8px; padding: 8px 14px; font-size: 13px; font-weight: 600; color: #14532D; }
        .wa-info svg { width: 15px; height: 15px; }
        .btn-back { display: inline-flex; align-items: center; gap: 6px; margin-top: 20px; padding: 10px 22px; border-radius: 8px; background: var(--secondary); color: #fff; font-weight: 600; font-size: 14px; text-decoration: none; transition: .12s; }
        .btn-back:hover { background: #27272A; }
        .btn-back:active { transform: translateY(0.5px) scale(0.985); }
        .btn-back svg { width: 14px; height: 14px; }

        /* FOOTER REDIRECT */
        .footer-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 24px;
            font-size: 12px;
        }
        .footer-link-btn {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            transition: opacity 0.2s;
        }
        .footer-link-btn:hover {
            opacity: 0.85;
            text-decoration: underline;
        }
        .footer-separator {
            color: var(--border);
        }

        .form-footer { padding: 16px 20px; text-align: center; margin-top: 40px; }
        .form-footer-brand { font-family: 'Bricolage Grotesque', sans-serif; font-size: 13px; font-weight: 700; margin-bottom: 3px; }
        .form-footer-copy { font-size: 11px; color: var(--muted); }
    </style>
</head>
<body>

<header class="topbar">
    <a href="/" class="logo" style="gap: 10px;">
        <div class="logo-box" style="background: transparent; border-radius: 0; width: 36px; height: 36px;">
            <img src="/logo.png" alt="NamuIn Logo" style="width: 100%; height: 100%; object-fit: contain; transform: scale(1.05);">
        </div>
        <span class="logo-text" style="font-size: 20px; font-weight: 800; letter-spacing: -0.5px;">NamuIn</span>
    </a>
    <span class="topbar-time" id="topbar-time"></span>
</header>

<div class="page-body">
    <div class="form-wrap">
        @if(session('success'))
            <div class="success-wrap">
                <div class="success-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </div>
                <h2>Pengajuan Berhasil!</h2>
                <p>{{ session('success') }}</p>
                <div class="wa-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" /></svg>
                    Notifikasi persetujuan dikirim ke staf terkait
                </div>
                <br>
                <a href="/" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12h19.5M2.25 12l8.25-8.25M2.25 12l8.25 8.25" /></svg>
                    Kembali ke Beranda
                </a>
            </div>
        @else
            <div class="hero">
                <h1>Pre-Booking Janji Temu</h1>
                <p>Buat jadwal kunjungan sebelum datang ke sekolah</p>
            </div>

            <div class="form-card">
                <form method="POST" action="{{ route('booking.store') }}">
                    @csrf

                    {{-- Honeypot Trap --}}
                    <div class="hp-field">
                        <label>Leave this empty</label>
                        <input type="text" name="secondary_phone" autocomplete="off" tabindex="-1">
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Nama Lengkap</label>
                        <input type="text" name="nama_tamu"
                            class="form-control {{ $errors->has('nama_tamu') ? 'error' : '' }}"
                            placeholder="Masukkan nama lengkap Anda"
                            value="{{ old('nama_tamu') }}">
                        @error('nama_tamu')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Asal Instansi</label>
                        <input type="text" name="instansi"
                            class="form-control {{ $errors->has('instansi') ? 'error' : '' }}"
                            placeholder="Contoh: PT. Maju Jaya atau Umum"
                            value="{{ old('instansi') }}">
                        @error('instansi')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Nomor WhatsApp</label>
                        <div class="phone-wrap">
                            <span class="phone-prefix">+62</span>
                            <input type="tel" name="no_wa"
                                class="form-control {{ $errors->has('no_wa') ? 'error' : '' }}"
                                placeholder="812xxxxxxx"
                                value="{{ old('no_wa') }}">
                        </div>
                        @error('no_wa')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Kategori Tamu</label>
                        <select name="kategori_id" class="form-control {{ $errors->has('kategori_id') ? 'error' : '' }}">
                            <option value="">Pilih kategori...</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="divider"><hr><span>Jadwal & Tujuan</span><hr></div>

                    <div class="form-group">
                        <label class="form-label required">Staf yang Ingin Ditemui</label>
                        <select id="bertemu-select" name="bertemu_dengan" placeholder="Cari nama staf..." autocomplete="off">
                            <option value="">Pilih atau ketik nama staf...</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}"
                                    data-jabatan="{{ $p->jabatan }}"
                                    data-dept="{{ $p->departemen }}"
                                    {{ old('bertemu_dengan') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                        <div id="staf-preview" style="display:none" class="staf-card">
                            <div class="staf-avatar" id="staf-avatar">?</div>
                            <div>
                                <div class="staf-name" id="staf-name">-</div>
                                <div class="staf-job" id="staf-job">-</div>
                            </div>
                        </div>
                        @error('bertemu_dengan')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">Tanggal Kunjungan</label>
                            <input type="date" name="tanggal_booking"
                                class="form-control {{ $errors->has('tanggal_booking') ? 'error' : '' }}"
                                min="{{ date('Y-m-d') }}"
                                value="{{ old('tanggal_booking') }}">
                            @error('tanggal_booking')<p class="form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Waktu Kunjungan</label>
                            <select name="jam_booking" class="form-control {{ $errors->has('jam_booking') ? 'error' : '' }}">
                                <option value="">Pilih waktu...</option>
                                <option value="08:00" {{ old('jam_booking') == '08:00' ? 'selected' : '' }}>08:00 - 09:00 WIB</option>
                                <option value="09:00" {{ old('jam_booking') == '09:00' ? 'selected' : '' }}>09:00 - 10:00 WIB</option>
                                <option value="10:00" {{ old('jam_booking') == '10:00' ? 'selected' : '' }}>10:00 - 11:00 WIB</option>
                                <option value="11:00" {{ old('jam_booking') == '11:00' ? 'selected' : '' }}>11:00 - 12:00 WIB</option>
                                <option value="13:00" {{ old('jam_booking') == '13:00' ? 'selected' : '' }}>13:00 - 14:00 WIB</option>
                                <option value="14:00" {{ old('jam_booking') == '14:00' ? 'selected' : '' }}>14:00 - 15:00 WIB</option>
                            </select>
                            @error('jam_booking')<p class="form-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Tujuan Kunjungan</label>
                        <input type="text" name="tujuan_kunjungan"
                            class="form-control {{ $errors->has('tujuan_kunjungan') ? 'error' : '' }}"
                            placeholder="Contoh: Diskusi Perkembangan Anak, Konsultasi Ujian, dll"
                            value="{{ old('tujuan_kunjungan') }}">
                        @error('tujuan_kunjungan')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Detail Keperluan <span style="color:var(--muted);font-weight:400;text-transform:none;letter-spacing:0">(opsional)</span></label>
                        <textarea name="detail_keperluan"
                            class="form-control {{ $errors->has('detail_keperluan') ? 'error' : '' }}"
                            placeholder="Jelaskan secara singkat rincian keperluan Anda">{{ old('detail_keperluan') }}</textarea>
                        @error('detail_keperluan')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        Kirim Pengajuan Booking
                        <span class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </span>
                    </button>
                </form>
            </div>

            <div class="footer-links">
                <a href="{{ route('home') }}" class="footer-link-btn">Check-In Lobi</a>
                <span class="footer-separator">|</span>
                <a href="{{ route('checkout.form') }}" class="footer-link-btn">Check-Out Mandiri</a>
            </div>
        @endif

        <footer class="form-footer">
            <div class="form-footer-brand">NamuIn</div>
            <div class="form-footer-copy">developed by some peeps in XI RPL 1</div>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
function updateClock() {
    const now = new Date();
    const h = String(now.getHours()).padStart(2, '0');
    const m = String(now.getMinutes()).padStart(2, '0');
    document.getElementById('topbar-time').textContent = h + ':' + m;
}
updateClock();
setInterval(updateClock, 30000);

const pegawaiData = @json($pegawais ?? []);
const map = {};
pegawaiData.forEach(p => { map[p.id] = p; });

const ts = new TomSelect('#bertemu-select', {
    placeholder: 'Cari nama staf...',
    allowEmptyOption: true,
    render: {
        option: function(data, escape) {
            const p = map[data.value];
            if (!p) return `<div class="option">${escape(data.text)}</div>`;
            return `<div class="option">
                <strong>${escape(p.nama)}</strong>
                <div class="job">${escape(p.jabatan)}${p.departemen ? ' · ' + escape(p.departemen) : ''}</div>
            </div>`;
        },
        item: function(data, escape) {
            const p = map[data.value];
            return `<div>${escape(p ? p.nama : data.text)}</div>`;
        }
    },
    onChange: function(value) {
        const preview = document.getElementById('staf-preview');
        if (!value || !map[value]) { preview.style.display = 'none'; return; }
        const p = map[value];
        document.getElementById('staf-avatar').textContent = p.nama.charAt(0).toUpperCase();
        document.getElementById('staf-name').textContent = p.nama;
        document.getElementById('staf-job').textContent = p.jabatan + (p.departemen ? ' · ' + p.departemen : '');
        preview.style.display = 'flex';
    }
});

@if(old('bertemu_dengan'))
ts.setValue('{{ old('bertemu_dengan') }}');
@endif
</script>
</body>
</html>
