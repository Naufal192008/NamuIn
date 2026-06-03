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
            --primary-glow: rgba(255, 107, 0, 0.45);
            --bg-dark: #09090B;
            --bg-card: rgba(22, 22, 26, 0.7);
            --text-light: #F4F4F5;
            --text-muted: #A1A1AA;
            --border-glow: rgba(255, 107, 0, 0.15);
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-light);
            background-color: var(--bg-dark);
            overflow: hidden;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
            /* Glowing circular gradients in background */
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(255, 107, 0, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(255, 107, 0, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(9, 9, 11, 0.95) 0%, rgba(9, 9, 11, 1) 100%),
                url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='2' cy='2' r='1' fill='rgba(255,255,255,0.015)'/%3E%3C/svg%3E");
            background-repeat: repeat;
        }

        /* CARD WITH GLASSMORPHISM */
        .card {
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 32px;
            box-shadow: 
                0 30px 70px -10px rgba(0, 0, 0, 0.6), 
                0 0 40px -5px rgba(255, 107, 0, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            padding: 40px 48px;
            max-width: 520px;
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        /* BRAND */
        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 24px;
        }
        .brand-dot {
            width: 32px; height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--primary) 0%, #FF8F3D 100%);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px var(--primary-glow);
        }
        .brand-dot svg { width: 16px; height: 16px; color: #fff; }
        .brand h1 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 24px; font-weight: 800;
            letter-spacing: -.5px;
            background: linear-gradient(to right, #FFFFFF, #E4E4E7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* QR WRAPPER WITH SCAN EFFECT */
        .qr-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #FFFFFF;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 28px;
            position: relative;
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.4),
                0 0 25px rgba(255, 107, 0, 0.15);
            overflow: hidden;
            border: 2px solid var(--border-glow);
        }
        .qr-wrapper #qrcode canvas,
        .qr-wrapper #qrcode img {
            display: block;
        }

        /* Laser line scan animation */
        .qr-scanner-line {
            position: absolute;
            left: 10px;
            right: 10px;
            height: 3px;
            background: linear-gradient(90deg, rgba(255,107,0,0) 0%, var(--primary) 50%, rgba(255,107,0,0) 100%);
            box-shadow: 0 0 10px var(--primary), 0 0 4px var(--primary);
            animation: laserScan 3s ease-in-out infinite;
            z-index: 5;
            pointer-events: none;
        }

        @keyframes laserScan {
            0% { top: 12px; }
            50% { top: calc(100% - 15px); }
            100% { top: 12px; }
        }

        /* Outer glowing brackets */
        .qr-corner {
            position: absolute;
            width: 24px; height: 24px;
            border-color: var(--primary);
            border-style: solid;
            pointer-events: none;
        }
        .qr-corner.tl { top: -2px; left: -2px; border-width: 4px 0 0 4px; border-radius: 6px 0 0 0; }
        .qr-corner.tr { top: -2px; right: -2px; border-width: 4px 4px 0 0; border-radius: 0 6px 0 0; }
        .qr-corner.bl { bottom: -2px; left: -2px; border-width: 0 0 4px 4px; border-radius: 0 0 0 6px; }
        .qr-corner.br { bottom: -2px; right: -2px; border-width: 0 4px 4px 0; border-radius: 0 0 6px 0; }

        /* TEXT */
        .instruction {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 28px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 8px;
            letter-spacing: -0.6px;
        }
        .instruction span { 
            color: var(--primary); 
            text-shadow: 0 0 20px rgba(255, 107, 0, 0.3);
        }

        .sub {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        /* STEPS GRID */
        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 28px;
        }
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 12px 6px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .step:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 107, 0, 0.3);
        }
        .step-num {
            width: 22px; height: 22px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 8px var(--primary-glow);
        }
        .step-icon { color: var(--text-muted); }
        .step-icon svg { width: 18px; height: 18px; }
        .step-label { font-size: 9.5px; font-weight: 600; color: #D4D4D8; text-align: center; line-height: 1.3; }

        /* URL CHIP */
        .url-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 99px;
            padding: 6px 16px;
            font-size: 12px;
            color: var(--text-muted);
            font-family: ui-monospace, SFMono-Regular, monospace;
            margin-bottom: 24px;
            transition: color 0.2s;
        }
        .url-chip:hover {
            color: #fff;
        }
        .url-chip svg { width: 13px; height: 13px; flex-shrink: 0; color: var(--primary); }

        /* DIVIDER */
        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.08);
            margin: 0 -48px 24px;
        }

        /* ACTIONS */
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn svg { width: 14px; height: 14px; }
        .btn-ghost { 
            background: rgba(255, 255, 255, 0.04); 
            border: 1px solid rgba(255, 255, 255, 0.08); 
            color: var(--text-light); 
        }
        .btn-ghost:hover { 
            background: rgba(255, 255, 255, 0.08); 
            border-color: rgba(255, 255, 255, 0.15); 
        }
        .btn-orange { 
            background: var(--primary); 
            color: #fff; 
            box-shadow: 0 4px 14px var(--primary-glow);
        }
        .btn-orange:hover { 
            background: #E55F00; 
            transform: translateY(-1px);
        }
        .btn:active {
            transform: translateY(0.5px);
        }

        /* DYNAMIC UTILITIES: FULLSCREEN & CLOCK */
        .fullscreen-btn {
            position: fixed;
            top: 20px; right: 20px;
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--bg-card);
            border: 1px solid rgba(255,255,255,0.06);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.2s;
            z-index: 50;
        }
        .fullscreen-btn:hover { background: rgba(255, 255, 255, 0.05); color: #fff; }
        .fullscreen-btn svg { width: 18px; height: 18px; }

        .clock-widget {
            position: fixed;
            top: 20px; left: 20px;
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            display: flex; align-items: center; gap: 8px;
            font-variant-numeric: tabular-nums;
            z-index: 50;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }
        .clock-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--primary);
            box-shadow: 0 0 8px var(--primary);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.95); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.5; }
        }

        /* LIVE ACTIVITY FEED BOTTOM BAR */
        .live-feed-ticker {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: 48px;
            background: rgba(15, 15, 20, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            z-index: 100;
            display: flex;
            align-items: center;
            padding: 0 24px;
            overflow: hidden;
            font-size: 13px;
        }
        .live-feed-label {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--primary);
            color: #fff;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-right: 16px;
            flex-shrink: 0;
            box-shadow: 0 2px 6px var(--primary-glow);
        }
        .ticker-marquee {
            flex: 1;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            height: 100%;
        }
        .ticker-items {
            display: flex;
            align-items: center;
            gap: 40px;
            white-space: nowrap;
            will-change: transform;
            animation: marquee 25s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }
        .ticker-item {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #E4E4E7;
        }
        .ticker-item span.highlight {
            color: var(--primary);
            font-weight: 600;
        }
        .ticker-sep {
            color: rgba(255, 255, 255, 0.15);
        }

        /* PRINT STYLES */
        @media print {
            *, *::before, *::after { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            html, body { height: auto; background: #fff; color: #000; padding: 0; }
            .fullscreen-btn, .clock-widget, .actions, .live-feed-ticker { display: none !important; }
            body { display: block; padding: 0; }
            .card {
                background: #fff;
                box-shadow: none;
                border-radius: 0;
                border: none;
                max-width: 100%;
                padding: 32px;
                margin: 0 auto;
                color: #000;
                page-break-inside: avoid;
            }
            .brand h1 {
                -webkit-text-fill-color: #000;
            }
            .qr-wrapper {
                border: 2px solid #000;
                box-shadow: none;
            }
            .qr-scanner-line { display: none !important; }
            .divider { margin: 0 -32px 20px; background: #000; }
            .step {
                background: #f4f4f5 !important;
                border: 1px solid #e4e4e7 !important;
                color: #000;
            }
            .step-label { color: #000; }
        }
    </style>
</head>
<body>

<div class="clock-widget">
    <div class="clock-dot"></div>
    <span id="clock">--:--:--</span>
</div>

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
        <div class="qr-scanner-line"></div>
        <div class="qr-corner tl"></div>
        <div class="qr-corner tr"></div>
        <div class="qr-corner bl"></div>
        <div class="qr-corner br"></div>
    </div>

    <p class="instruction">Pindai QR untuk<br><span>Check-in Mandiri</span></p>
    <p class="sub">Arahkan kamera ponsel Anda ke kode QR di atas<br>untuk melakukan pengisian formulir kunjungan secara digital.</p>

    <div class="steps">
        <div class="step">
            <div class="step-num">1</div>
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" /></svg>
            </div>
            <div class="step-label">Buka Kamera</div>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" /></svg>
            </div>
            <div class="step-label">Pindai QR</div>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" /></svg>
            </div>
            <div class="step-label">Isi Biodata</div>
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
            Cetak Poster
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

<div class="live-feed-ticker">
    <div class="live-feed-label">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:14px;height:14px"><path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" /><path fill-rule="evenodd" d="M.664 9.592a1 1 0 0 1 1.412.072 12.915 12.915 0 0 0 15.848 0 1 1 0 1 1 1.484 1.412A14.915 14.915 0 0 1 .592 11.004 1 1 0 0 1 .664 9.592Z" clip-rule="evenodd" /><path fill-rule="evenodd" d="M3.337 6.177a1 1 0 0 1 1.371-.27 8.962 8.962 0 0 0 10.584 0 1 1 0 1 1 1.1 1.634 10.962 10.962 0 0 1-12.954 0 1 1 0 0 1-.1-.137Z" clip-rule="evenodd" /></svg>
        Aktivitas
    </div>
    <div class="ticker-marquee">
        <div class="ticker-items" id="ticker-items">
            <!-- Dynamic ticker items will slide in here -->
        </div>
    </div>
</div>

<script>
    const QR_URL = "{{ $checkinUrl }}";

    // Set up QR Code
    new QRCode(document.getElementById("qrcode"), {
        text: QR_URL,
        width: 220,
        height: 220,
        colorDark: "#09090B",
        colorLight: "#FFFFFF",
        correctLevel: QRCode.CorrectLevel.H
    });

    // Clock
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').textContent = h + ':' + m + ':' + s;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Fullscreen Toggle
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

    // Download QR Code
    function downloadQR() {
        const canvas = document.querySelector('#qrcode canvas');
        if (!canvas) { alert('QR code belum siap'); return; }
        const link = document.createElement('a');
        link.download = 'namuin-qr-checkin.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    }

    // Monitor fullscreen change events
    document.addEventListener('fullscreenchange', () => {
        const isFs = !!document.fullscreenElement;
        document.getElementById('fs-icon-expand').style.display = isFs ? 'none' : 'block';
        document.getElementById('fs-icon-shrink').style.display = isFs ? 'block' : 'none';
    });

    // Real-time visitor feed integration
    const feedUrl = "{{ route('display.live-feed') }}";
    async function refreshLiveFeed() {
        try {
            const response = await fetch(feedUrl);
            if (!response.ok) return;
            const data = await response.json();
            
            const container = document.getElementById('ticker-items');
            let content = '';

            // Main stats summary
            content += `<div class="ticker-item">Total Kunjungan Hari Ini: <span class="highlight">${data.total} Tamu</span></div>`;
            content += `<div class="ticker-sep">|</div>`;

            if (data.recent && data.recent.length > 0) {
                data.recent.forEach(t => {
                    content += `<div class="ticker-item">Checked-in: <span class="highlight">${t.nama}</span> (${t.instansi}) <span style="opacity:0.6">${t.jam}</span></div>`;
                    content += `<div class="ticker-sep">|</div>`;
                });
                // Duplicate for smooth infinite scroll effect
                data.recent.forEach(t => {
                    content += `<div class="ticker-item">Checked-in: <span class="highlight">${t.nama}</span> (${t.instansi}) <span style="opacity:0.6">${t.jam}</span></div>`;
                    content += `<div class="ticker-sep">|</div>`;
                });
            } else {
                content += `<div class="ticker-item">Belum ada kunjungan tamu hari ini. Silakan melakukan check-in mandiri.</div>`;
            }

            container.innerHTML = content;
        } catch (err) {
            console.error('Gagal mengambil live feed:', err);
        }
    }

    refreshLiveFeed();
    // Poll stats and feed details every 10 seconds
    setInterval(refreshLiveFeed, 10000);
</script>
</body>
</html>
