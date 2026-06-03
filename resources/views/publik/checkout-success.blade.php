<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NamuIn — Check-out Berhasil</title>
    <meta name="description" content="Check-out berhasil di NamuIn.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        .form-wrap { max-width: 480px; width: 100%; margin: 0 auto; }
        .form-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 20px 40px -15px rgba(9, 9, 11, 0.05);
            text-align: center;
        }

        /* SUCCESS ICON */
        .success-icon {
            width: 72px; height: 72px; border-radius: 50%;
            background: #DCFCE7;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
        }
        .success-icon svg { width: 36px; height: 36px; color: #16A34A; }

        .success-title { font-family: 'Bricolage Grotesque', sans-serif; font-size: 24px; font-weight: 800; margin-bottom: 8px; color: #14532D; }
        .sub { font-size: 13.5px; color: var(--muted); line-height: 1.6; margin-bottom: 24px; }

        /* LOG DETAILS CARD */
        .log-details {
            background: #F4F4F5;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            text-align: left;
            margin-bottom: 24px;
        }
        .log-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }
        .log-row:last-child {
            border-bottom: none;
        }
        .log-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--muted);
        }
        .log-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }
        .log-value.duration {
            color: var(--primary);
            font-family: ui-monospace, SFMono-Regular, monospace;
            font-weight: 700;
            font-size: 15px;
        }

        .btn-back { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 13px; border: none; border-radius: 8px; background: var(--secondary); color: #fff; font-size: 14px; font-weight: 700; cursor: pointer; text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif; margin-top: 12px; transition: .15s cubic-bezier(0.16, 1, 0.3, 1); }
        .btn-back:hover { background: #27272A; }
        .btn-back:active { transform: translateY(0.5px) scale(0.985); }
        .btn-back svg { width: 16px; height: 16px; }
        .btn-back .arrow { background: var(--primary); width: 28px; height: 28px; border-radius: 5px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .btn-back .arrow svg { width: 14px; height: 14px; }

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
        <div class="form-card">
            <div class="success-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>

            <h2 class="success-title">Check-out Berhasil</h2>
            <p class="sub">Terima kasih atas kunjungan Anda di sekolah kami. Data kepulangan Anda telah dicatat oleh sistem.</p>

            <div class="log-details">
                <div class="log-row">
                    <span class="log-label">Nama Tamu</span>
                    <span class="log-value">{{ $tamu->nama_tamu }}</span>
                </div>
                <div class="log-row">
                    <span class="log-label">Asal Instansi</span>
                    <span class="log-value">{{ $tamu->instansi }}</span>
                </div>
                <div class="log-row">
                    <span class="log-label">Jam Masuk</span>
                    <span class="log-value">{{ $tamu->jam_masuk->format('H:i') }} WIB</span>
                </div>
                <div class="log-row">
                    <span class="log-label">Jam Pulang</span>
                    <span class="log-value">{{ $tamu->jam_pulang->format('H:i') }} WIB</span>
                </div>
                <div class="log-row">
                    <span class="log-label">Durasi Kunjungan</span>
                    <span class="log-value duration">{{ $tamu->durasi }}</span>
                </div>
            </div>

            <a href="{{ route('home') }}" class="btn-back">
                Kembali ke Beranda
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </span>
            </a>
        </div>

        <footer class="form-footer">
            <div class="form-footer-brand">NamuIn</div>
            <div class="form-footer-copy">developed by some peeps in XI RPL 1</div>
        </footer>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('topbar-time').textContent = h + ':' + m;
    }
    updateClock();
    setInterval(updateClock, 30000);
</script>
</body>
</html>
