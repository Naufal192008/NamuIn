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
        html, body { height: 100%; }
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
        }

        /* ─── LEFT QR PANEL ─── */
        .qr-panel {
            width: 40%;
            min-width: 340px;
            background: radial-gradient(circle at 50% 50%, rgba(9, 9, 11, 0.98) 0%, rgba(20, 20, 25, 0.99) 90%), url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='2' cy='2' r='1' fill='rgba(255,255,255,0.03)'/%3E%3C/svg%3E");
            background-repeat: repeat;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 28px;
            position: sticky;
            top: 53px;
            height: calc(100vh - 53px);
            border-right: 1px solid rgba(255,255,255,0.05);
        }
        .qr-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 32px; font-weight: 800;
            color: #fff; text-align: center; line-height: 1.15;
            letter-spacing: -0.8px;
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
        .hero h1 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 32px; font-weight: 800; color: var(--text); margin-bottom: 6px; letter-spacing: -0.8px; line-height: 1.1; }
        .hero p { font-size: 13px; color: var(--muted); font-weight: 500; }

        .form-wrap { max-width: 520px; margin: 0 auto; padding: 0 20px 40px; width: 100%; }
        .form-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 20px 40px -15px rgba(9, 9, 11, 0.05);
        }

        .form-group { margin-bottom: 18px; }
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
        .btn-checkin:active { transform: translateY(0.5px) scale(0.985); }
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
        .btn-back:active { transform: translateY(0.5px) scale(0.985); }
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

        /* ─── HONEYPOT ─── */
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

        /* ─── BOOKING QUICK CHECK-IN TRIGGER ─── */
        .booking-trigger-container {
            margin-bottom: 20px;
        }
        .btn-booking-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            background: linear-gradient(135deg, rgba(255,107,0,0.06) 0%, rgba(255,107,0,0.12) 100%);
            border: 1.5px dashed rgba(255,107,0,0.4);
            border-radius: 14px;
            color: var(--primary);
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            text-align: left;
        }
        .btn-booking-trigger:hover {
            background: linear-gradient(135deg, rgba(255,107,0,0.1) 0%, rgba(255,107,0,0.18) 100%);
            border-style: solid;
            transform: translateY(-1px);
        }
        .btn-booking-trigger .trigger-icon {
            background: var(--primary);
            color: #fff;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        /* ─── LIGHT-THEMED BOOKING MODAL ─── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(9, 9, 11, 0.4);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        .modal-container {
            width: 100%;
            max-width: 440px;
            margin: 20px;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 30px 60px -15px rgba(9, 9, 11, 0.15);
            color: var(--text);
            transform: scale(0.95) translateY(10px);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .modal-overlay.active .modal-container {
            transform: scale(1) translateY(0);
        }
        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .modal-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text);
        }
        .modal-close {
            background: #F4F4F5;
            border: none;
            color: var(--muted);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .modal-close:hover {
            background: #E4E4E7;
            color: var(--text);
        }
        .modal-close svg {
            width: 14px;
            height: 14px;
        }
        .modal-body p {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.5;
            margin-bottom: 20px;
        }
        .modal-input-group {
            margin-bottom: 20px;
        }
        .modal-input {
            width: 100%;
            padding: 14px 18px;
            background: #FAFAFA;
            border: 1.5px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            font-size: 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            letter-spacing: 2px;
            text-align: center;
            text-transform: uppercase;
            outline: none;
            transition: all 0.2s;
        }
        .modal-input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.08);
        }
        .modal-input::placeholder {
            letter-spacing: normal;
            font-weight: 500;
            text-transform: none;
            font-size: 14px;
            color: var(--muted);
        }
        .btn-modal-submit {
            width: 100%;
            padding: 13px;
            background: var(--secondary);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-modal-submit:hover {
            background: #27272a;
        }
        .btn-modal-submit:active {
            transform: scale(0.98);
        }

        /* ─── REDIRECT LINKS ─── */
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
    </style>
</head>
<body class="{{ request()->query('from') === 'qr' ? 'from-qr' : '' }}">

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
            @if(session('error'))
            <div style="background: #FEE2E2; border: 1.5px solid #FCA5A5; color: #991B1B; padding: 14px 20px; border-radius: 12px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px; height:18px; flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <div class="booking-trigger-container">
                <button type="button" class="btn-booking-trigger" id="open-booking-modal">
                    <span>Punya Kode Booking? Check-in Instan</span>
                    <span class="trigger-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 12px; height: 12px; display: block;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </span>
                </button>
            </div>

            <div class="form-card">
                <form method="POST" action="{{ route('checkin.store') }}">
                    @csrf

                    <div class="hp-field">
                        <label>Leave this empty</label>
                        <input type="text" name="secondary_phone" autocomplete="off" tabindex="-1">
                    </div>

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

                    <div class="form-group" style="display:flex; align-items:center; gap:10px; margin: 10px 0 20px">
                        <input type="checkbox" name="sudah_janji" id="sudah_janji" value="1" {{ old('sudah_janji') ? 'checked' : '' }} style="width:18px; height:18px; accent-color:var(--primary); cursor:pointer; margin:0">
                        <label for="sudah_janji" style="font-size:13px; font-weight:600; cursor:pointer; user-select:none; color:var(--text); text-transform:none; letter-spacing:0">Sudah memiliki janji temu sebelumnya</label>
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

            <div class="footer-links">
                <a href="{{ route('checkout.form') }}" class="footer-link-btn">Check-Out Mandiri</a>
                <span class="footer-separator">|</span>
                <a href="{{ route('booking.form') }}" class="footer-link-btn">Pre-Booking Janji Temu</a>
            </div>
        </div>
        @endif

        <footer class="form-footer">
            <div class="form-footer-brand">NamuIn</div>
            <div class="form-footer-copy">developed by some peeps in XI RPL 1</div>
        </footer>
    </div>

</div>

{{-- ─── BOOKING MODAL ─── --}}
<div class="modal-overlay" id="booking-modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Check-in Booking</h3>
            <button class="modal-close" id="close-booking-modal" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <p>Masukkan Kode Booking Anda (misal: NMU-ABCDE) untuk melakukan check-in instan.</p>
            <form method="POST" action="{{ route('checkin.booking') }}">
                @csrf
                
                {{-- Honeypot trap --}}
                <div class="hp-field">
                    <label>Leave this empty</label>
                    <input type="text" name="secondary_phone" autocomplete="off" tabindex="-1">
                </div>

                <div class="modal-input-group">
                    <input type="text" name="booking_code" class="modal-input" placeholder="NMU-XXXXX" required autocomplete="off">
                </div>
                
                <button type="submit" class="btn-modal-submit">
                    <span>Check-in Sekarang</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </button>
            </form>
        </div>
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

// Booking Code Modal JS
const modalOverlay = document.getElementById('booking-modal-overlay');
const openModalBtn = document.getElementById('open-booking-modal');
const closeModalBtn = document.getElementById('close-booking-modal');

if (openModalBtn && modalOverlay) {
    openModalBtn.addEventListener('click', () => {
        modalOverlay.classList.add('active');
        const input = modalOverlay.querySelector('.modal-input');
        if (input) setTimeout(() => input.focus(), 150);
    });
}

if (closeModalBtn && modalOverlay) {
    closeModalBtn.addEventListener('click', () => {
        modalOverlay.classList.remove('active');
    });
    
    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            modalOverlay.classList.remove('active');
        }
    });
}
</script>

</body>
</html>
