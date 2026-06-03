<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NamuIn — Self Check-out Kunjungan</title>
    <meta name="description" content="Form check-out buku tamu digital NamuIn.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        .form-wrap { max-width: 480px; width: 100%; margin: 0 auto; }
        .hero { text-align: center; margin-bottom: 28px; }
        .hero h1 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 32px; font-weight: 800; color: var(--text); margin-bottom: 6px; letter-spacing: -0.8px; line-height: 1.1; }
        .hero h1 span { color: var(--primary); }
        .hero p { font-size: 14px; color: var(--muted); font-weight: 500; }

        .form-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 36px;
            box-shadow: 0 20px 40px -15px rgba(9, 9, 11, 0.05);
        }

        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--muted); margin-bottom: 7px; }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            background: #FAFAFA;
            outline: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .form-control:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.08);
        }
        .phone-wrap { display: flex; align-items: stretch; }
        .phone-prefix { display: flex; align-items: center; padding: 0 14px; background: #F4F4F5; border: 1.5px solid var(--border); border-right: none; border-radius: 10px 0 0 10px; font-size: 14px; color: var(--muted); font-weight: 600; }
        .phone-wrap .form-control { border-radius: 0 10px 10px 0; }
        .form-error { font-size: 12px; color: #DC2626; margin-top: 5px; }

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

        /* ALERT */
        .alert-error {
            background: #FEE2E2;
            border: 1.5px solid #FCA5A5;
            color: #991B1B;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .alert-error svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* LINKS */
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
        <div class="hero">
            <h1>Check-out <span>Kunjungan</span></h1>
            <p>Masukkan nomor WhatsApp Anda untuk menyelesaikan kunjungan hari ini secara mandiri</p>
        </div>

        <div class="form-card">
            @if(session('error'))
                <div class="alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('checkout.submit') }}">
                @csrf

                {{-- Honeypot Trap --}}
                <div class="hp-field">
                    <label>Leave this empty</label>
                    <input type="text" name="secondary_phone" autocomplete="off" tabindex="-1">
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp</label>
                    <div class="phone-wrap">
                        <span class="phone-prefix">+62</span>
                        <input type="tel" name="no_wa" class="form-control" placeholder="812xxxxxxx" required autofocus>
                    </div>
                    @error('no_wa')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn-submit">
                    Selesaikan Kunjungan
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </span>
                </button>
            </form>
        </div>

        <div class="footer-links">
            <a href="{{ route('home') }}" class="footer-link-btn">Check-In Lobi</a>
            <span class="footer-separator">|</span>
            <a href="{{ route('booking.form') }}" class="footer-link-btn">Pre-Booking Janji Temu</a>
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
