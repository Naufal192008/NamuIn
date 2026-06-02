<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NamuIn — Buku Tamu Digital SMK</title>
    <meta name="description" content="Form check-in buku tamu digital NamuIn. Isi data kunjungan Anda dengan mudah.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#f97316;--orange-dark:#ea580c;--text:#111827;--muted:#6b7280;--border:#e5e7eb;--bg:#f9fafb}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;flex-direction:column}

        header{background:#fff;padding:14px 20px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border)}
        .logo{display:flex;align-items:center;gap:8px;font-size:17px;font-weight:700;color:var(--orange)}
        .logo-icon{font-size:20px}
        header .help{font-size:18px;color:var(--muted);cursor:pointer}

        .hero{text-align:center;padding:28px 20px 12px}
        .hero h1{font-size:26px;font-weight:800;margin-bottom:4px}
        .hero p{font-size:14px;color:var(--muted)}

        .form-wrap{max-width:420px;margin:0 auto;padding:0 20px 40px;width:100%}
        .form-card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:24px}

        .form-group{margin-bottom:18px}
        .form-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);margin-bottom:7px}
        .form-label.highlight{color:var(--orange-dark)}
        .form-control{
            width:100%;padding:11px 14px;border:1.5px solid var(--border);
            border-radius:9px;font-size:14px;font-family:inherit;color:var(--text);
            background:#fff;transition:.15s;outline:none;
        }
        .form-control:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(249,115,22,.12)}
        .form-control.error{border-color:#ef4444}
        select.form-control{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:36px}
        .phone-wrap{display:flex;align-items:stretch;gap:0}
        .phone-prefix{display:flex;align-items:center;padding:0 12px;background:#f3f4f6;border:1.5px solid var(--border);border-right:none;border-radius:9px 0 0 9px;font-size:14px;color:var(--muted);font-weight:500}
        .phone-wrap .form-control{border-radius:0 9px 9px 0}
        textarea.form-control{resize:none;min-height:90px}
        .form-error{font-size:12px;color:#ef4444;margin-top:5px}

        .btn-checkin{
            display:flex;align-items:center;justify-content:center;gap:8px;
            width:100%;padding:14px;border:none;border-radius:10px;
            background:var(--orange);color:#fff;font-size:15px;font-weight:700;
            cursor:pointer;font-family:inherit;margin-top:24px;transition:.15s;
        }
        .btn-checkin:hover{background:var(--orange-dark);transform:translateY(-1px)}
        .btn-checkin:active{transform:none}

        .success-wrap{text-align:center;padding:40px 20px}
        .success-icon{font-size:56px;margin-bottom:16px}
        .success-wrap h2{font-size:22px;font-weight:700;margin-bottom:8px;color:#065f46}
        .success-wrap p{color:var(--muted);font-size:14px;line-height:1.6}
        .btn-back{display:inline-flex;align-items:center;gap:6px;margin-top:20px;padding:10px 20px;border-radius:8px;background:var(--orange);color:#fff;font-weight:600;font-size:14px;text-decoration:none;font-family:inherit}

        footer{margin-top:auto;text-align:center;padding:20px;border-top:1px solid var(--border);background:#fff}
        footer .footer-brand{font-size:14px;font-weight:700;margin-bottom:4px}
        footer .footer-copy{font-size:12px;color:var(--muted);margin-bottom:10px}
        footer .footer-links{display:flex;justify-content:center;gap:16px}
        footer .footer-links a{font-size:12px;color:var(--muted);text-decoration:none}
        footer .footer-links a:hover{color:var(--text)}
        footer .footer-credit{font-size:11px;color:#9ca3af;margin-top:6px}
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <span class="logo-icon">📋</span>
            NamuIn
        </div>
        <span class="help" title="Bantuan">?</span>
    </header>

    @if(session('success'))
    <div class="form-wrap">
        <div class="success-wrap">
            <div class="success-icon">✅</div>
            <h2>Check-in Berhasil!</h2>
            <p>{{ session('success') }}</p>
            <a href="/" class="btn-back">← Kembali ke Form</a>
        </div>
    </div>
    @else
    <div class="hero">
        <h1>Selamat Datang</h1>
        <p>SMK Negeri 1 Jakarta</p>
    </div>

    <div class="form-wrap">
        <div class="form-card">
            <form method="POST" action="{{ route('checkin.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_tamu" class="form-control {{ $errors->has('nama_tamu') ? 'error' : '' }}"
                        placeholder="Masukkan nama sesuai KTP" value="{{ old('nama_tamu') }}">
                    @error('nama_tamu')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Asal Instansi</label>
                    <input type="text" name="instansi" class="form-control {{ $errors->has('instansi') ? 'error' : '' }}"
                        placeholder="Contoh: PT. Maju Jaya atau Umum" value="{{ old('instansi') }}">
                    @error('instansi')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor WhatsApp</label>
                    <div class="phone-wrap">
                        <span class="phone-prefix">+62</span>
                        <input type="tel" name="no_wa" class="form-control {{ $errors->has('no_wa') ? 'error' : '' }}"
                            placeholder="812xxxxxxx" value="{{ old('no_wa') }}">
                    </div>
                    @error('no_wa')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label highlight">Sebagai</label>
                    <select name="kategori_id" class="form-control {{ $errors->has('kategori_id') ? 'error' : '' }}">
                        <option value="">Pilih</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tujuan Kunjungan</label>
                    <input type="text" name="tujuan_kunjungan" class="form-control {{ $errors->has('tujuan_kunjungan') ? 'error' : '' }}"
                        placeholder="Contoh: Ruang TU atau Nama Guru" value="{{ old('tujuan_kunjungan') }}">
                    @error('tujuan_kunjungan')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Detail Keperluan</label>
                    <textarea name="detail_keperluan" class="form-control {{ $errors->has('detail_keperluan') ? 'error' : '' }}"
                        placeholder="Jelaskan secara singkat alasan kunjungan Anda">{{ old('detail_keperluan') }}</textarea>
                    @error('detail_keperluan')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn-checkin">
                    Check In Sekarang →
                </button>
            </form>
        </div>
    </div>
    @endif

    <footer>
        <div class="footer-brand">NamuIn</div>
        <div class="footer-copy">© {{ date('Y') }} Namuin. All rights reserved.</div>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Support</a>
        </div>
        <div class="footer-credit">Copyright Namuin by XAMPP_Crash</div>
    </footer>
</body>
</html>
