<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NamuIn — Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#f97316;--orange-dark:#ea580c;--text:#111827;--muted:#6b7280;--border:#e5e7eb}
        body{font-family:'Inter',sans-serif;min-height:100vh;display:flex}

        .left-panel{
            flex:1;background:#1a1a2e;position:relative;overflow:hidden;
            display:flex;align-items:flex-end;
        }
        .left-panel img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.85}
        .left-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(26,26,46,.6) 0%,rgba(26,26,46,.2) 100%)}

        .right-panel{
            width:460px;min-width:420px;background:#fff;
            display:flex;flex-direction:column;justify-content:space-between;padding:40px;
        }
        .brand h1{font-size:24px;font-weight:800;color:var(--text);letter-spacing:-.3px}
        .brand p{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1.5px;color:var(--muted);margin-top:3px}

        .login-form{flex:1;display:flex;flex-direction:column;justify-content:center;padding:20px 0}
        .login-form h2{font-size:22px;font-weight:700;margin-bottom:28px}

        .form-group{margin-bottom:16px}
        .form-label-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:7px}
        .form-label{font-size:13px;font-weight:500;color:var(--text)}
        .form-link{font-size:13px;color:var(--orange);text-decoration:none;font-weight:500}
        .form-link:hover{text-decoration:underline}
        .form-control{
            width:100%;padding:10px 14px;border:1.5px solid var(--border);
            border-radius:8px;font-size:14px;font-family:inherit;color:var(--text);
            outline:none;transition:.15s;background:#f9fafb;
        }
        .form-control:focus{border-color:var(--orange);background:#fff;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
        .form-control.error{border-color:#ef4444}
        .form-error{font-size:12px;color:#ef4444;margin-top:4px}

        .remember-row{display:flex;align-items:center;gap:8px;margin-bottom:20px}
        .remember-row input{width:15px;height:15px;accent-color:var(--orange)}
        .remember-row label{font-size:13px;color:var(--muted)}

        .btn-login{
            width:100%;padding:12px;border:none;border-radius:8px;
            background:var(--orange);color:#fff;font-size:15px;font-weight:700;
            cursor:pointer;font-family:inherit;transition:.15s;
        }
        .btn-login:hover{background:var(--orange-dark)}

        .form-footer{text-align:center;padding-top:20px}
        .form-footer p{font-size:12px;color:var(--muted);margin-bottom:8px}
        .form-footer-links{display:flex;justify-content:center;gap:16px}
        .form-footer-links a{font-size:12px;color:var(--muted);text-decoration:none}
        .form-footer-links a:hover{color:var(--text)}

        @media(max-width:768px){
            .left-panel{display:none}
            .right-panel{width:100%;min-width:unset;padding:32px 24px}
        }
    </style>
</head>
<body>
    <div class="left-panel">
        <img src="/images/login-lobby.png" alt="Reception lobby">
        <div class="left-overlay"></div>
    </div>

    <div class="right-panel">
        <div class="brand">
            <h1>NamuIn</h1>
            <p>Digital Guestbook Management</p>
        </div>

        <div class="login-form">
            <h2>Sign in to your account</h2>

            @if($errors->any())
                <div style="background:#fee2e2;color:#991b1b;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px;border:1px solid #fca5a5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="name@company.com" value="{{ old('email') }}" autofocus>
                </div>

                <div class="form-group">
                    <div class="form-label-row">
                        <label class="form-label">Password</label>
                        <a href="#" class="form-link">Forget Password?</a>
                    </div>
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'error' : '' }}"
                        placeholder="••••••••">
                </div>

                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember Me</label>
                </div>

                <button type="submit" class="btn-login">Login</button>
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
