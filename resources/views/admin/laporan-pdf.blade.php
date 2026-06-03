<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kunjungan — NamuIn</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{
            box-sizing:border-box;margin:0;padding:0;
            -webkit-print-color-adjust:exact !important;
            print-color-adjust:exact !important;
        }
        :root{
            --primary:#FF6B00;
            --secondary:#09090B;
            --tertiary:#049EFF;
            --neutral:#71717A;
            --dark:#09090B;
        }
        body{font-family:'Plus Jakarta Sans',Arial,sans-serif;font-size:12px;background:#E4E4E7;color:#09090B;min-height:100vh;padding:24px}

        .no-print{margin-bottom:20px;display:flex;gap:10px;justify-content:flex-end}
        .no-print button{padding:9px 20px;border:none;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:6px}
        .btn-print{background:var(--secondary);color:#fff}
        .btn-print:hover{background:#27272A}
        .btn-close{background:#fff;color:var(--secondary);border:1px solid #E4E4E7}
        .btn-close:hover{background:#F4F4F5}

        .document{background:#fff;max-width:760px;margin:0 auto;border-radius:8px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.12)}

        /* HEADER */
        .doc-header{background:var(--secondary);color:#fff;padding:28px 32px 24px}
        .doc-header-inner{display:flex;justify-content:space-between;align-items:flex-start}
        .doc-header-left h1{font-family:'Bricolage Grotesque',sans-serif;font-size:20px;font-weight:800;line-height:1.2;margin-bottom:4px}
        .doc-header-left .periode{font-size:12px;color:#A1A1AA;margin-top:6px;font-weight:400}
        .doc-header-left .meta-row{display:flex;gap:24px;margin-top:10px;font-size:11px;color:#71717A}
        .doc-header-left .meta-row span b{color:#E4E4E7;font-weight:600}
        .doc-header-right{text-align:right}
        .doc-header-right .brand{font-family:'Bricolage Grotesque',sans-serif;font-size:22px;font-weight:800;color:var(--primary);letter-spacing:-.5px}
        .doc-header-right .brand-sub{font-size:10px;color:#71717A;text-transform:uppercase;letter-spacing:1px;margin-top:2px}

        /* STATS */
        .stats-row{display:grid;grid-template-columns:repeat(4,1fr);border-bottom:1px solid #e5e7eb}
        .stat-box{padding:20px 24px;border-right:1px solid #e5e7eb}
        .stat-box:last-child{border-right:none}
        .stat-box .lbl{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--neutral);margin-bottom:8px}
        .stat-box .num{font-family:'Bricolage Grotesque',sans-serif;font-size:28px;font-weight:800;color:var(--secondary);line-height:1}
        .stat-box .num.green{color:#16A34A}
        .stat-box .num.orange{color:var(--primary)}
        .stat-box .num.blue{color:var(--tertiary)}
        .stat-box .desc{font-size:10px;color:#A1A1AA;margin-top:5px}

        /* KATEGORI CHART */
        .section{padding:24px 32px;border-bottom:1px solid #E4E4E7}
        .section-title{font-family:'Bricolage Grotesque',sans-serif;font-size:14px;font-weight:700;color:var(--secondary);margin-bottom:16px}

        .bar-row{display:flex;align-items:center;gap:12px;margin-bottom:10px}
        .bar-label{width:120px;font-size:11px;color:var(--secondary);text-align:right;flex-shrink:0;font-weight:500}
        .bar-track{flex:1;height:22px;background:#F4F4F5;border-radius:3px;overflow:hidden;position:relative}
        .bar-fill{height:100%;background:var(--primary);border-radius:3px;display:flex;align-items:center;padding-left:8px;min-width:30px;transition:none}
        .bar-fill-text{font-size:10px;font-weight:700;color:#fff;white-space:nowrap}
        .bar-value{width:60px;font-size:11px;font-weight:700;color:var(--primary);flex-shrink:0}

        /* TABLE */
        .table-wrap{padding:0 32px 0}
        table{width:100%;border-collapse:collapse}
        thead th{padding:9px 12px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--neutral);border-bottom:1.5px solid #E4E4E7;border-top:1.5px solid #E4E4E7;text-align:left;background:#F4F4F5}
        tbody td{padding:9px 12px;border-bottom:1px solid #F4F4F5;font-size:11px;vertical-align:middle;color:#27272A}
        tbody tr:last-child td{border-bottom:none}
        tbody tr:nth-child(even) td{background:#FAFAFA}
        .no-col{font-weight:700;color:#A1A1AA;width:28px}
        .name-bold{font-weight:600;color:var(--secondary)}
        .sub-text{font-size:10px;color:#A1A1AA;margin-top:1px}

        .badge{display:inline-block;padding:2px 9px;border-radius:99px;font-size:10px;font-weight:700}
        .badge-menunggu{background:#FEF3C7;color:#92400E}
        .badge-ditemui{background:#DBEAFE;color:#1E40AF}
        .badge-selesai{background:#DCFCE7;color:#14532D}
        .tag{display:inline-block;padding:1px 7px;border-radius:3px;font-size:10px;font-weight:700}

        /* TOTAL ROW */
        .total-row td{font-weight:700;background:#F4F4F5;border-top:1.5px solid #E4E4E7;color:var(--secondary);font-size:11px}

        /* SIGNATURE */
        .signature-section{padding:28px 32px;border-top:1px solid #e5e7eb;display:flex;justify-content:space-between;margin-top:4px}
        .sig-box{text-align:center;width:200px}
        .sig-box .sig-title{font-size:11px;color:#71717A;margin-bottom:60px}
        .sig-box .sig-line{border-top:1.5px solid var(--secondary);padding-top:6px}
        .sig-box .sig-name{font-size:12px;font-weight:700;color:var(--secondary)}
        .sig-box .sig-role{font-size:10px;color:var(--neutral)}

        /* FOOTER */
        .doc-footer{background:#F4F4F5;border-top:1px solid #E4E4E7;padding:12px 32px;display:flex;justify-content:space-between;align-items:center;font-size:10px;color:#A1A1AA}
        .doc-footer b{color:var(--primary)}

        @media print{
            body{background:#fff;padding:0}
            .no-print{display:none !important}
            .document{box-shadow:none;border-radius:0;max-width:100%}
            @page{margin:10mm;size:A4}
        }
    </style>
</head>
<body>

<div class="no-print">
    <button class="btn-close" onclick="window.close()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
        Tutup
    </button>
    <button class="btn-print" onclick="window.print()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" /></svg>
        Cetak / Simpan PDF
    </button>
</div>

<div class="document">

    {{-- HEADER --}}
    <div class="doc-header">
        <div class="doc-header-inner">
            <div class="doc-header-left">
                <h1>Laporan Data Kunjungan<br>Tamu Sekolah</h1>
                <div class="periode">Periode {{ \Carbon\Carbon::parse($dari)->format('d F Y') }} — {{ \Carbon\Carbon::parse($sampai)->format('d F Y') }}</div>
                <div class="meta-row">
                    <span>Dicetak: <b>{{ now()->format('d F Y, H:i') }} WIB</b></span>
                    <span>Oleh: <b>{{ auth()->user()->name ?? 'Admin' }}</b></span>
                </div>
            </div>
            <div class="doc-header-right">
                <div class="brand">NamuIn</div>
                <div class="brand-sub">Digital Guestbook System</div>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    @php
        $total    = $data->count();
        $selesai  = $data->where('status','Selesai')->count();
        $menunggu = $data->where('status','Menunggu')->count();
        $ditemui  = $data->where('status','Sedang Ditemui')->count();

        $byKategori = $data->groupBy(fn($t) => $t->kategori?->nama_kategori ?? 'Lainnya')
            ->map->count()
            ->sortDesc();
        $maxKat = $byKategori->max() ?: 1;
    @endphp

    <div class="stats-row">
        <div class="stat-box">
            <div class="lbl">Total Tamu</div>
            <div class="num">{{ $total }}</div>
            <div class="desc">Kunjungan tercatat</div>
        </div>
        <div class="stat-box">
            <div class="lbl">Selesai</div>
            <div class="num green">{{ $selesai }}</div>
            <div class="desc">Kunjungan selesai</div>
        </div>
        <div class="stat-box">
            <div class="lbl">Menunggu</div>
            <div class="num orange">{{ $menunggu }}</div>
            <div class="desc">Tamu menunggu</div>
        </div>
        <div class="stat-box">
            <div class="lbl">Sedang Ditemui</div>
            <div class="num blue">{{ $ditemui }}</div>
            <div class="desc">Sedang berlangsung</div>
        </div>
    </div>

    {{-- CHART KATEGORI --}}
    @if($byKategori->isNotEmpty())
    <div class="section">
        <div class="section-title">Kunjungan per Kategori</div>
        @foreach($byKategori as $nama => $jumlah)
        @php $pct = round($jumlah / $maxKat * 100) @endphp
        <div class="bar-row">
            <div class="bar-label">{{ $nama }}</div>
            <div class="bar-track">
                <div class="bar-fill" style="width:{{ max($pct, 8) }}%">
                    <span class="bar-fill-text">{{ $jumlah }} tamu</span>
                </div>
            </div>
            <div class="bar-value">
                {{ $total > 0 ? round($jumlah / $total * 100) : 0 }}%
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- TABLE --}}
    <div class="section" style="padding-bottom:0">
        <div class="section-title">Rincian Kunjungan</div>
    </div>
    <div class="table-wrap" style="padding-bottom:4px">
        <table>
            <thead>
                <tr>
                    <th class="no-col">No</th>
                    <th>Nama Tamu</th>
                    <th>Kategori</th>
                    <th>Tujuan</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $tamu)
                <tr>
                    <td class="no-col">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div class="name-bold">{{ $tamu->nama_tamu }}</div>
                        <div class="sub-text">{{ $tamu->instansi }}</div>
                    </td>
                    <td>
                        @if($tamu->kategori)
                        <span class="tag" style="background:{{ $tamu->kategori->warna }}22;color:{{ $tamu->kategori->warna }}">
                            {{ $tamu->kategori->nama_kategori }}
                        </span>
                        @else
                        <span style="color:#9ca3af">—</span>
                        @endif
                    </td>
                    <td>{{ $tamu->tujuan_kunjungan }}</td>
                    <td style="white-space:nowrap;color:#374151">{{ $tamu->jam_masuk->format('d/m H:i') }}</td>
                    <td style="white-space:nowrap;color:#374151">{{ $tamu->jam_pulang ? $tamu->jam_pulang->format('H:i') : '—' }}</td>
                    <td>
                        @if($tamu->status === 'Menunggu')
                            <span class="badge badge-menunggu">Menunggu</span>
                        @elseif($tamu->status === 'Sedang Ditemui')
                            <span class="badge badge-ditemui">Ditemui</span>
                        @else
                            <span class="badge badge-selesai">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:#9ca3af;padding:32px">Tidak ada data untuk periode ini</td></tr>
                @endforelse

                @if($data->count() > 0)
                <tr class="total-row">
                    <td colspan="3" style="padding-left:12px">Total Keseluruhan</td>
                    <td colspan="2">{{ $total }} kunjungan</td>
                    <td></td>
                    <td><span class="badge badge-selesai">{{ $selesai }} Selesai</span></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- SIGNATURE --}}
    <div class="signature-section">
        <div class="sig-box">
            <div class="sig-title">Mengetahui,<br>Kepala Sekolah</div>
            <div class="sig-line">
                <div class="sig-name">( ___________________ )</div>
                <div class="sig-role">NIP. _________________</div>
            </div>
        </div>
        <div class="sig-box">
            <div class="sig-title">Dibuat oleh,<br>Petugas Resepsionis</div>
            <div class="sig-line">
                <div class="sig-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="sig-role">{{ ucfirst(auth()->user()->role ?? 'Receptionist') }}</div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="doc-footer">
        <span>Dokumen ini digenerate otomatis oleh sistem <b>NamuIn</b> pada {{ now()->format('d F Y, H:i') }} WIB.</span>
        <span>Halaman 1 dari 1</span>
    </div>

</div>

<script>
    window.onload = function() {
        if (new URLSearchParams(window.location.search).get('autoprint') === '1') {
            setTimeout(() => window.print(), 600);
        }
    }
</script>

</body>
</html>
