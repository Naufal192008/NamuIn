<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NamuIn — Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        :root {
            --primary: #FF6B00;
            --primary-dark: #E55F00;
            --secondary: #09090B;
            --tertiary: #049EFF;
            --neutral: #71717A;
            --text: #09090B;
            --border: #E4E4E7
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #F4F4F5
        }

        .left-panel {
            flex: 1;
            background: var(--secondary);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
        }

        .left-panel img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .7;
            mix-blend-mode: luminosity
        }

        .left-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(9, 9, 11, .3) 0%, rgba(9, 9, 11, .7) 100%)
        }

        .left-content {
            position: relative;
            z-index: 2;
            padding: 36px;
            color: #fff
        }

        .left-content .lc-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 107, 0, .2);
            border: 1px solid rgba(255, 107, 0, .4);
            border-radius: 99px;
            padding: 4px 12px;
            font-size: 11px;
            font-weight: 600;
            color: #FF9A50;
            margin-bottom: 12px
        }

        .left-content h2 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 28px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 8px
        }

        .left-content p {
            font-size: 13px;
            color: rgba(255, 255, 255, .6);
            line-height: 1.6
        }

        .right-panel {
            width: 440px;
            min-width: 400px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px;
            border-left: 1px solid var(--border);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .brand-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--primary)
        }

        .brand h1 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -.3px
        }

        .brand p {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--neutral);
            margin-left: 18px;
            margin-top: 2px
        }

        .login-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 24px 0
        }

        .login-form h2 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 6px
        }

        .login-form .sub {
            font-size: 13px;
            color: var(--neutral);
            margin-bottom: 28px
        }

        .alert-err {
            background: #FEF2F2;
            color: #991B1B;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 16px;
            border: 1px solid #FECACA;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .form-group {
            margin-bottom: 16px
        }

        .form-label-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 7px
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .form-link {
            font-size: 12px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600
        }

        .form-link:hover {
            text-decoration: underline
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            outline: none;
            transition: .15s;
            background: #FAFAFA;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(255, 107, 0, .1)
        }

        .form-control.error {
            border-color: #DC2626
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px
        }

        .remember-row input {
            width: 15px;
            height: 15px;
            accent-color: var(--primary)
        }

        .remember-row label {
            font-size: 13px;
            color: var(--neutral)
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: var(--secondary);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: .15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: #27272A
        }

        .btn-login .arrow {
            background: var(--primary);
            width: 26px;
            height: 26px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px
        }

        .form-footer {
            padding-top: 20px;
            border-top: 1px solid var(--border);
            margin-top: 20px
        }

        .form-footer p {
            font-size: 11px;
            color: var(--neutral);
            text-align: center;
            margin-bottom: 8px
        }

        .form-footer-links {
            display: flex;
            justify-content: center;
            gap: 16px
        }

        .form-footer-links a {
            font-size: 11px;
            color: var(--neutral);
            text-decoration: none
        }

        .form-footer-links a:hover {
            color: var(--text)
        }

        @media(max-width:768px) {
            .left-panel {
                display: none
            }

            .right-panel {
                width: 100%;
                min-width: unset;
                padding: 32px 24px
            }
        }
    </style>
</head>

<body>
    <div class="left-panel">
        <img src="/images/hotel.jpg" alt="Reception lobby">
        <div class="left-overlay"></div>
        <div class="left-content">
            <div class="lc-tag">
                <span style="width:6px;height:6px;border-radius:50%;background:#FF6B00;display:inline-block"></span>
                Digital Guestbook
            </div>
            <h2>Kelola Tamu Sekolah<br>dengan Mudah</h2>
            <p>Sistem buku tamu digital yang memudahkan resepsionis mencatat dan memantau setiap kunjungan secara
                real-time.</p>
        </div>
    </div>

    <div class="right-panel">
        <div>
            <div class="brand">
                <div class="brand-dot"></div>
                <h1>NamuIn</h1>
            </div>
            <p class="brand"
                style="display:block;margin-top:3px;margin-left:18px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:#71717A">
                Digital Guestbook Management</p>
        </div>

        <div class="login-form">
            <h2>Sign in to your<br>account</h2>
            <p class="sub">Masuk untuk mengelola buku tamu sekolah</p>

            @if($errors->any())
                <div class="alert-err">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" style="width:16px;height:16px;flex-shrink:0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="nama@sekolah.sch.id" value="{{ old('email') }}" autofocus>
                </div>

                <div class="form-group">
                    <div class="form-label-row">
                        <label class="form-label">Password</label>
                        <a href="#" class="form-link">Lupa Password?</a>
                    </div>
                    <input type="password" name="password"
                        class="form-control {{ $errors->has('password') ? 'error' : '' }}" placeholder="••••••••">
                </div>

                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label>
                </div>

                <button type="submit" class="btn-login">
                    Masuk ke Dashboard
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" style="width:13px;height:13px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </button>
            </form>
        </div>

        <div class="form-footer">
            <p>© {{ date('Y') }} NamuIn by XAMPP_Crash. All rights reserved.</p>
            <div class="form-footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Support</a>
            </div>
        </div>
    </div>
</body>

</html>