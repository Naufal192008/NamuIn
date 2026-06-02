<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NamuIn — Check-in Tamu</title>
    <meta name="description" content="Form check-in buku tamu digital NamuIn.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
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
        html, body { height: 100%; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
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
        }

        /* ─── LEFT QR PANEL ─── */
        .qr-panel {
            width: 40%;
            min-width: 340px;
            background: var(--secondary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 28px;
            position: sticky;
            top: 53px;
            height: calc(100vh - 53px);
        }
        .qr-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 26px; font-weight: 800;
            color: #fff; text-align: center; line-height: 1.25;
        }
        .qr-title em { color: var(--primary); font-style: normal; }
        .qr-box {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            position: relative;
        }
        .qr-box #qrcode-left canvas,
        .qr-box #qrcode-left img { display: block; border-radius: 4px; }
        .qr-corner { position: absolute; width: 20px; height: 20px; border-color: var(--primary); border-style: solid; }
        .qr-corner.tl { top: 8px; left: 8px; border-width: 3px 0 0 3px; border-radius: 4px 0 0 0; }
        .qr-corner.tr { top: 8px; right: 8px; border-width: 3px 3px 0 0; border-radius: 0 4px 0 0; }
        .qr-corner.bl { bottom: 8px; left: 8px; border-width: 0 0 3px 3px; border-radius: 0 0 0 4px; }
        .qr-corner.br { bottom: 8px; right: 8px; border-width: 0 3px 3px 0; border-radius: 0 0 4px 0; }

        /* ─── RIGHT FORM PANEL ─── */
        .form-panel {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        .hero { text-align: center; padding: 28px 20px 12px; }
        .hero h1 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 26px; font-weight: 800; color: var(--text); margin-bottom: 4px; }
        .hero p { font-size: 13px; color: var(--muted); font-weight: 500; }

        .form-wrap { max-width: 480px; margin: 0 auto; padding: 0 20px 40px; width: 100%; }
        .form-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 24px; box-shadow: 0 1px 4px rgba(0,0,0,.04); }

        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--muted); margin-bottom: 7px; }
        .form-label.required::after { content: ' *'; color: var(--primary); }
        .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text); background: #fff; transition: .15s; outline: none; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(255,107,0,.1); }
        .form-control.error { border-color: #DC2626; }
        select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2371717A' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }
        .phone-wrap { display: flex; align-items: stretch; }
        .phone-prefix { display: flex; align-items: center; padding: 0 12px; background: #F4F4F5; border: 1.5px solid var(--border); border-right: none; border-radius: 8px 0 0 8px; font-size: 14px; color: var(--muted); font-weight: 600; }
        .phone-wrap .form-control { border-radius: 0 8px 8px 0; }
        textarea.form-control { resize: none; min-height: 90px; }
        .form-error { font-size: 12px; color: #DC2626; margin-top: 5px; }

        .divider { display: flex; align-items: center; gap: 12px; margin: 4px 0 18px; }
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

        .btn-checkin { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 13px; border: none; border-radius: 8px; background: var(--secondary); color: #fff; font-size: 14px; font-weight: 700; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; margin-top: 24px; transition: .15s; }
        .btn-checkin:hover { background: #27272A; }
        .btn-checkin svg { width: 16px; height: 16px; }
        .btn-checkin .arrow { background: var(--primary); width: 28px; height: 28px; border-radius: 5px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .btn-checkin .arrow svg { width: 14px; height: 14px; }

        /* SUCCESS */
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
        .btn-back svg { width: 14px; height: 14px; }

        /* FOOTER */
        .form-footer { padding: 16px 20px; border-top: 1px solid var(--border); background: #fff; text-align: center; }
        .form-footer-brand { font-family: 'Bricolage Grotesque', sans-serif; font-size: 13px; font-weight: 700; margin-bottom: 3px; }
        .form-footer-copy { font-size: 11px; color: var(--muted); }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 860px) {
            .qr-panel { min-width: 260px; }
            .qr-title { font-size: 20px; }
        }
        @media (max-width: 640px) {
            .qr-panel { display: none; }
            .form-panel { overflow-y: visible; }
        }
        body.from-qr .qr-panel { display: none; }
    </style>
</head>
<body class="{{ request()->query('from') === 'qr' ? 'from-qr' : '' }}">

<header class="topbar">
    <a href="/" class="logo">
        <div class="logo-box">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z"/>
                <path fill-rule="evenodd" d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z" clip-rule="evenodd"/>
            </svg>
        </div>
        <span class="logo-text">NamuIn</span>
    </a>
    <span class="topbar-time" id="topbar-time"></span>
</header>

<div class="page-body">

    {{-- ─── QR PANEL (kiri, tablet+) ─── --}}
    <aside class="qr-panel">
        <p class="qr-title">Scan QR untuk<br><em>Mulai Check-in</em></p>

        <div class="qr-box">
            <div id="qrcode-left"></div>
            <div class="qr-corner tl"></div>
            <div class="qr-corner tr"></div>
            <div class="qr-corner bl"></div>
            <div class="qr-corner br"></div>
        </div>
    </aside>

    {{-- ─── FORM PANEL (kanan) ─── --}}
    <div class="form-panel">
        @if(session('success'))
        <div class="form-wrap" style="padding-top:24px">
            <div class="success-wrap">
                <div class="success-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </div>
                <h2>Check-in Berhasil!</h2>
                <p>{{ session('success') }}</p>
                <div class="wa-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" /></svg>
                    Notifikasi WhatsApp telah dikirim
                </div>
                <br>
                <a href="/" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                    Kembali ke Form
                </a>
            </div>
        </div>
        @else
        <div class="hero">
            <h1>Selamat Datang</h1>
            <p>Silakan isi formulir check-in kunjungan Anda</p>
        </div>

        <div class="form-wrap">
            <div class="form-card">
                <form method="POST" action="{{ route('checkin.store') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label required">Nama Lengkap</label>
                        <input type="text" name="nama_tamu"
                            class="form-control {{ $errors->has('nama_tamu') ? 'error' : '' }}"
                            placeholder="Masukkan nama sesuai KTP"
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
                        <label class="form-label required" style="color:var(--primary)">Kategori Tamu</label>
                        <select name="kategori_id" class="form-control {{ $errors->has('kategori_id') ? 'error' : '' }}">
                            <option value="">Pilih kategori</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="divider"><hr><span>Tujuan Kunjungan</span><hr></div>

                    <div class="form-group">
                        <label class="form-label required">Ingin Bertemu Dengan</label>
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

                    <div class="form-group">
                        <label class="form-label required">Tujuan Kunjungan</label>
                        <input type="text" name="tujuan_kunjungan"
                            class="form-control {{ $errors->has('tujuan_kunjungan') ? 'error' : '' }}"
                            placeholder="Contoh: Konsultasi siswa, Tagihan, dll"
                            value="{{ old('tujuan_kunjungan') }}">
                        @error('tujuan_kunjungan')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Detail Keperluan <span style="color:var(--muted);font-weight:400;text-transform:none;letter-spacing:0">(opsional)</span></label>
                        <textarea name="detail_keperluan"
                            class="form-control {{ $errors->has('detail_keperluan') ? 'error' : '' }}"
                            placeholder="Jelaskan lebih detail keperluan kunjungan Anda">{{ old('detail_keperluan') }}</textarea>
                        @error('detail_keperluan')<p class="form-error">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-checkin">
                        Check In Sekarang
                        <span class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>
        @endif

        <footer class="form-footer">
            <div class="form-footer-brand">NamuIn</div>
            <div class="form-footer-copy">© {{ date('Y') }} NamuIn. All rights reserved.</div>
        </footer>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
const QR_URL = "{{ url('/?from=qr') }}";

if (document.getElementById('qrcode-left')) {
    new QRCode(document.getElementById('qrcode-left'), {
        text: QR_URL,
        width: 220,
        height: 220,
        colorDark: '#09090B',
        colorLight: '#FFFFFF',
        correctLevel: QRCode.CorrectLevel.H
    });
}

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
