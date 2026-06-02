<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NamuIn — Buku Tamu Digital SMK</title>
    <meta name="description" content="Form check-in buku tamu digital NamuIn.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.min.css" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--primary:#FF6B00;--primary-dark:#E55F00;--secondary:#09090B;--tertiary:#049EFF;--neutral:#71717A;--text:#09090B;--muted:#71717A;--border:#E4E4E7;--bg:#F4F4F5}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;flex-direction:column}

        header{background:#fff;padding:14px 20px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border)}
        .logo{display:flex;align-items:center;gap:8px;font-family:'Bricolage Grotesque',sans-serif;font-size:18px;font-weight:800;color:var(--text)}
        .logo-dot{width:8px;height:8px;border-radius:50%;background:var(--primary)}
        header .help{width:28px;height:28px;border-radius:50%;border:1.5px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--muted);cursor:pointer}

        .hero{text-align:center;padding:32px 20px 16px}
        .hero h1{font-family:'Bricolage Grotesque',sans-serif;font-size:28px;font-weight:800;color:var(--text);margin-bottom:4px}
        .hero p{font-size:14px;color:var(--muted);font-weight:500}

        .form-wrap{max-width:440px;margin:0 auto;padding:0 20px 40px;width:100%}
        .form-card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:24px;box-shadow:0 1px 4px rgba(0,0,0,.04)}

        .form-group{margin-bottom:18px}
        .form-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);margin-bottom:7px}
        .form-label.required::after{content:' *';color:var(--primary)}
        .form-control{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:14px;font-family:'Plus Jakarta Sans',sans-serif;color:var(--text);background:#fff;transition:.15s;outline:none}
        .form-control:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(255,107,0,.1)}
        .form-control.error{border-color:#DC2626}
        select.form-control{appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2371717A' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 12px center;padding-right:36px}
        .phone-wrap{display:flex;align-items:stretch}
        .phone-prefix{display:flex;align-items:center;padding:0 12px;background:#F4F4F5;border:1.5px solid var(--border);border-right:none;border-radius:8px 0 0 8px;font-size:14px;color:var(--muted);font-weight:600}
        .phone-wrap .form-control{border-radius:0 8px 8px 0}
        textarea.form-control{resize:none;min-height:90px}
        .form-error{font-size:12px;color:#DC2626;margin-top:5px}

        .divider{display:flex;align-items:center;gap:12px;margin:4px 0 18px}
        .divider hr{flex:1;border:none;border-top:1px solid var(--border)}
        .divider span{font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px}

        .ts-wrapper .ts-control{border:1.5px solid var(--border) !important;border-radius:8px !important;font-family:'Plus Jakarta Sans',sans-serif !important;font-size:14px !important;padding:8px 12px !important;box-shadow:none !important;min-height:42px !important}
        .ts-wrapper.focus .ts-control{border-color:var(--primary) !important;box-shadow:0 0 0 3px rgba(255,107,0,.1) !important}
        .ts-wrapper .ts-control input{font-family:'Plus Jakarta Sans',sans-serif !important;font-size:14px !important}
        .ts-dropdown{border:1.5px solid var(--border) !important;border-radius:8px !important;box-shadow:0 8px 24px rgba(0,0,0,.1) !important;font-family:'Plus Jakarta Sans',sans-serif !important}
        .ts-dropdown .option{padding:10px 14px !important;font-size:13px !important}
        .ts-dropdown .option:hover,.ts-dropdown .option.active{background:rgba(255,107,0,.08) !important;color:var(--primary) !important}
        .ts-dropdown .option .job{font-size:11px;color:var(--muted);margin-top:1px}
        .ts-dropdown .create{color:var(--primary) !important}

        .pegawai-card{background:#F4F4F5;border:1.5px solid var(--border);border-radius:8px;padding:10px 14px;display:flex;align-items:center;gap:10px;margin-top:8px}
        .pegawai-avatar{width:36px;height:36px;border-radius:50%;background:var(--primary);color:#fff;font-weight:700;font-size:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .pegawai-name{font-weight:700;font-size:13px}
        .pegawai-job{font-size:11px;color:var(--muted)}

        .btn-checkin{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:13px;border:none;border-radius:8px;background:var(--secondary);color:#fff;font-size:14px;font-weight:700;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;margin-top:24px;transition:.15s}
        .btn-checkin:hover{background:#27272A}
        .btn-checkin .arrow{background:var(--primary);width:28px;height:28px;border-radius:5px;display:flex;align-items:center;justify-content:center;font-size:14px;margin-left:4px;flex-shrink:0}

        .success-wrap{text-align:center;padding:48px 20px}
        .success-icon{width:72px;height:72px;border-radius:50%;background:#DCFCE7;display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 16px}
        .success-wrap h2{font-family:'Bricolage Grotesque',sans-serif;font-size:22px;font-weight:700;margin-bottom:8px;color:#14532D}
        .success-wrap p{color:var(--muted);font-size:14px;line-height:1.6}
        .wa-info{display:inline-flex;align-items:center;gap:6px;margin-top:12px;background:#DCFCE7;border:1px solid #BBF7D0;border-radius:8px;padding:8px 14px;font-size:13px;font-weight:600;color:#14532D}
        .btn-back{display:inline-flex;align-items:center;gap:6px;margin-top:20px;padding:10px 22px;border-radius:8px;background:var(--secondary);color:#fff;font-weight:600;font-size:14px;text-decoration:none}

        footer{margin-top:auto;text-align:center;padding:20px;border-top:1px solid var(--border);background:#fff}
        footer .footer-brand{font-family:'Bricolage Grotesque',sans-serif;font-size:14px;font-weight:700;margin-bottom:4px}
        footer .footer-copy{font-size:12px;color:var(--muted);margin-bottom:10px}
        footer .footer-links{display:flex;justify-content:center;gap:16px}
        footer .footer-links a{font-size:12px;color:var(--muted);text-decoration:none}
    </style>
</head>
<body>
    <header>
        <div class="logo"><div class="logo-dot"></div>NamuIn</div>
        <div class="help">?</div>
    </header>

    @if(session('success'))
    <div class="form-wrap" style="padding-top:24px">
        <div class="success-wrap">
            <div class="success-icon">✅</div>
            <h2>Check-in Berhasil!</h2>
            <p>{{ session('success') }}</p>
            <div class="wa-info">📲 Notifikasi WhatsApp telah dikirim ke pihak yang dituju</div>
            <br>
            <a href="/" class="btn-back">← Kembali ke Form</a>
        </div>
    </div>
    @else
    <div class="hero">
        <h1>Selamat Datang</h1>
        <p>SMK Negeri 1 Jakarta — Silakan isi form check-in berikut</p>
    </div>

    <div class="form-wrap">
        <div class="form-card">
            <form method="POST" action="{{ route('checkin.store') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label required">Nama Lengkap</label>
                    <input type="text" name="nama_tamu" class="form-control {{ $errors->has('nama_tamu') ? 'error' : '' }}"
                        placeholder="Masukkan nama sesuai KTP" value="{{ old('nama_tamu') }}">
                    @error('nama_tamu')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Asal Instansi</label>
                    <input type="text" name="instansi" class="form-control {{ $errors->has('instansi') ? 'error' : '' }}"
                        placeholder="Contoh: PT. Maju Jaya atau Umum" value="{{ old('instansi') }}">
                    @error('instansi')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Nomor WhatsApp</label>
                    <div class="phone-wrap">
                        <span class="phone-prefix">+62</span>
                        <input type="tel" name="no_wa" class="form-control {{ $errors->has('no_wa') ? 'error' : '' }}"
                            placeholder="812xxxxxxx" value="{{ old('no_wa') }}">
                    </div>
                    @error('no_wa')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label required" style="color:var(--primary)">Sebagai</label>
                    <select name="kategori_id" class="form-control {{ $errors->has('kategori_id') ? 'error' : '' }}">
                        <option value="">Pilih kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="divider">
                    <hr><span>Tujuan Kunjungan</span><hr>
                </div>

                <div class="form-group">
                    <label class="form-label required">Ingin Bertemu Dengan</label>
                    <select id="bertemu-select" name="bertemu_dengan" placeholder="Cari nama pegawai..." autocomplete="off">
                        <option value="">Pilih atau ketik nama...</option>
                        @foreach($pegawais as $p)
                            <option value="{{ $p->id }}"
                                data-jabatan="{{ $p->jabatan }}"
                                data-dept="{{ $p->departemen }}"
                                {{ old('bertemu_dengan') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }}
                            </option>
                        @endforeach
                    </select>
                    <div id="pegawai-preview" style="display:none" class="pegawai-card">
                        <div class="pegawai-avatar" id="peg-avatar">?</div>
                        <div>
                            <div class="pegawai-name" id="peg-name">-</div>
                            <div class="pegawai-job" id="peg-job">-</div>
                        </div>
                    </div>
                    @error('bertemu_dengan')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label required">Tujuan Kunjungan</label>
                    <input type="text" name="tujuan_kunjungan" class="form-control {{ $errors->has('tujuan_kunjungan') ? 'error' : '' }}"
                        placeholder="Contoh: Konsultasi siswa, Tagihan, dll" value="{{ old('tujuan_kunjungan') }}">
                    @error('tujuan_kunjungan')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Detail Keperluan <span style="color:var(--muted);font-weight:400;text-transform:none;letter-spacing:0">(opsional)</span></label>
                    <textarea name="detail_keperluan" class="form-control {{ $errors->has('detail_keperluan') ? 'error' : '' }}"
                        placeholder="Jelaskan lebih detail keperluan kunjungan Anda">{{ old('detail_keperluan') }}</textarea>
                    @error('detail_keperluan')<p class="form-error">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn-checkin">
                    Check In Sekarang
                    <span class="arrow">→</span>
                </button>
            </form>
        </div>
    </div>
    @endif

    <footer>
        <div class="footer-brand">NamuIn</div>
        <div class="footer-copy">© {{ date('Y') }} NamuIn. All rights reserved.</div>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Support</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
    const pegawaiData = @json($pegawais ?? []);
    const map = {};
    pegawaiData.forEach(p => { map[p.id] = p; });

    const ts = new TomSelect('#bertemu-select', {
        placeholder: 'Cari nama pegawai...',
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
            const preview = document.getElementById('pegawai-preview');
            if (!value || !map[value]) { preview.style.display = 'none'; return; }
            const p = map[value];
            document.getElementById('peg-avatar').textContent = p.nama.charAt(0).toUpperCase();
            document.getElementById('peg-name').textContent = p.nama;
            document.getElementById('peg-job').textContent = p.jabatan + (p.departemen ? ' · ' + p.departemen : '');
            preview.style.display = 'flex';
        }
    });

    @if(old('bertemu_dengan'))
    ts.setValue('{{ old('bertemu_dengan') }}');
    @endif
    </script>
</body>
</html>
