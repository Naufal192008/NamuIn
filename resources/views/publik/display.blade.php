<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NamuIn — Scan untuk Check-in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #FF6B00;
            --secondary: #09090B;
            --bg: #F7F7F8;
        }

        html, body {
            height: 100%;
            background: var(--bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--secondary);
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }

        /* CARD */
        .card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 40px rgba(0,0,0,.08);
            padding: 40px 44px 36px;
            max-width: 480px;
            width: 100%;
            text-align: center;
            position: relative;
        }

        /* BRAND */
        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 28px;
        }
        .brand-dot {
            width: 28px; height: 28px;
            border-radius: 8px;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
        }
        .brand-dot svg { width: 14px; height: 14px; color: #fff; }
        .brand h1 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 22px; font-weight: 800;
            letter-spacing: -.3px;
        }

        /* QR WRAPPER */
        .qr-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--secondary);
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 24px;
            position: relative;
        }
        .qr-wrapper #qrcode canvas,
        .qr-wrapper #qrcode img {
            display: block;
            border-radius: 4px;
        }
        /* Corner decoration */
        .qr-corner {
            position: absolute;
            width: 20px; height: 20px;
            border-color: var(--primary);
            border-style: solid;
        }
        .qr-corner.tl { top: 8px; left: 8px; border-width: 3px 0 0 3px; border-radius: 4px 0 0 0; }
        .qr-corner.tr { top: 8px; right: 8px; border-width: 3px 3px 0 0; border-radius: 0 4px 0 0; }
        .qr-corner.bl { bottom: 8px; left: 8px; border-width: 0 0 3px 3px; border-radius: 0 0 0 4px; }
        .qr-corner.br { bottom: 8px; right: 8px; border-width: 0 3px 3px 0; border-radius: 0 0 4px 0; }

        /* TEXT */
        .instruction {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 22px;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 8px;
        }
        .instruction span { color: var(--primary); }

        .sub {
            font-size: 13px;
            color: #71717A;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        /* STEPS */
        .steps {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 28px;
        }
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            flex: 1;
            padding: 14px 8px;
            border-radius: 12px;
            background: #F7F7F8;
            border: 1.5px solid #E4E4E7;
        }
        .step-num {
            width: 24px; height: 24px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            display: flex; align-items: center; justify-content: center;
        }
        .step-icon { color: #71717A; }
        .step-icon svg { width: 20px; height: 20px; }
        .step-label { font-size: 10px; font-weight: 600; color: #52525B; text-align: center; line-height: 1.3; }

        /* URL CHIP */
        .url-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #F4F4F5;
            border: 1px solid #E4E4E7;
            border-radius: 99px;
            padding: 5px 14px;
            font-size: 12px;
            color: #71717A;
            font-family: ui-monospace, SFMono-Regular, monospace;
            margin-bottom: 24px;
            word-break: break-all;
        }
        .url-chip svg { width: 13px; height: 13px; flex-shrink: 0; }

        /* DIVIDER */
        .divider {
            height: 1px;
            background: #E4E4E7;
            margin: 0 -44px 24px;
        }

        /* ACTION BUTTONS */
        .actions {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: .12s;
        }
        .btn svg { width: 14px; height: 14px; }
        .btn-primary { background: var(--secondary); color: #fff; }
        .btn-primary:hover { background: #27272A; }
        .btn-ghost { background: transparent; border: 1.5px solid #E4E4E7; color: var(--secondary); }
        .btn-ghost:hover { background: #F4F4F5; }
        .btn-orange { background: var(--primary); color: #fff; }
        .btn-orange:hover { background: #E55F00; }

        /* FULLSCREEN TOGGLE */
        .fullscreen-btn {
            position: fixed;
            top: 16px; right: 16px;
            width: 36px; height: 36px;
            border-radius: 8px;
            background: #fff;
            border: 1.5px solid #E4E4E7;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: #71717A;
            transition: .12s;
        }
        .fullscreen-btn:hover { background: #F4F4F5; color: var(--secondary); }
        .fullscreen-btn svg { width: 16px; height: 16px; }

        /* CLOCK */
        .clock {
            position: fixed;
            top: 16px; left: 16px;
            background: #fff;
            border: 1.5px solid #E4E4E7;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 600;
            color: var(--secondary);
            font-variant-numeric: tabular-nums;
        }

        /* PRINT STYLES */
        @media print {
            *, *::before, *::after { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            html, body { height: auto; background: #fff; padding: 0; }
            .fullscreen-btn, .clock, .actions, .btn-ghost, .btn-orange { display: none !important; }
            body { display: block; padding: 0; }
            .card {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
                padding: 32px;
                margin: 0 auto;
                page-break-inside: avoid;
            }
            .divider { margin: 0 -32px 20px; }
        }
    </style>
</head>
<body>

<div class="clock" id="clock">--:--</div>

<button class="fullscreen-btn" id="fs-btn" onclick="toggleFullscreen()" title="Fullscreen">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="fs-icon-expand">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="fs-icon-shrink" style="display:none">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9 3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5 5.25 5.25" />
    </svg>
</button>

<div class="card">
    <div class="brand">
        <div class="brand-dot">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z" />
                <path fill-rule="evenodd" d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z" clip-rule="evenodd" />
            </svg>
        </div>
        <h1>NamuIn</h1>
    </div>

    <div class="qr-wrapper">
        <div id="qrcode"></div>
        <div class="qr-corner tl"></div>
        <div class="qr-corner tr"></div>
        <div class="qr-corner bl"></div>
        <div class="qr-corner br"></div>
    </div>

    <p class="instruction">Scan QR untuk<br><span>Check-in Kunjungan</span></p>
    <p class="sub">Arahkan kamera HP Anda ke kode QR di atas<br>untuk mengisi formulir tamu secara digital.</p>

    <div class="steps">
        <div class="step">
            <div class="step-num">1</div>
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" /></svg>
            </div>
            <div class="step-label">Buka Kamera HP</div>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" /></svg>
            </div>
            <div class="step-label">Scan QR Code</div>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg>
            </div>
            <div class="step-label">Isi Formulir</div>
        </div>
        <div class="step">
            <div class="step-num">4</div>
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>
            <div class="step-label">Selesai!</div>
        </div>
    </div>

    <div class="url-chip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 1 1.242 7.244" /></svg>
        {{ $checkinUrl }}
    </div>

    <div class="divider"></div>

    <div class="actions">
        <button class="btn btn-ghost" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" /></svg>
            Print / PDF
        </button>
        <button class="btn btn-ghost" onclick="downloadQR()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
            Unduh QR
        </button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-orange">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
            Dashboard
        </a>
    </div>
</div>

<script>
    const QR_URL = "{{ $checkinUrl }}";

    new QRCode(document.getElementById("qrcode"), {
        text: QR_URL,
        width: 220,
        height: 220,
        colorDark: "#09090B",
        colorLight: "#FFFFFF",
        correctLevel: QRCode.CorrectLevel.H
    });

    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').textContent = h + ':' + m + ':' + s;
    }
    updateClock();
    setInterval(updateClock, 1000);

    function toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            document.getElementById('fs-icon-expand').style.display = 'none';
            document.getElementById('fs-icon-shrink').style.display = 'block';
        } else {
            document.exitFullscreen();
            document.getElementById('fs-icon-expand').style.display = 'block';
            document.getElementById('fs-icon-shrink').style.display = 'none';
        }
    }

    function downloadQR() {
        const canvas = document.querySelector('#qrcode canvas');
        if (!canvas) { alert('QR belum siap'); return; }
        const link = document.createElement('a');
        link.download = 'namuin-qr-checkin.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }

    document.addEventListener('fullscreenchange', () => {
        const isFs = !!document.fullscreenElement;
        document.getElementById('fs-icon-expand').style.display = isFs ? 'none' : 'block';
        document.getElementById('fs-icon-shrink').style.display = isFs ? 'block' : 'none';
    });
</script>
</body>
</html>
