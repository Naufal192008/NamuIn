<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NamuIn Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,700;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --primary:#FF6B00;
            --primary-dark:#E55F00;
            --primary-bg:rgba(255,107,0,.08);
            --secondary:#09090B;
            --tertiary:#049EFF;
            --sidebar-w:224px;
            --text:#09090B;
            --text-muted:#71717A;
            --border:#E4E4E7;
            --bg:#F4F4F5;
            --white:#FFFFFF;
            --green:#16A34A;
            --green-bg:#DCFCE7;
            --blue:#0369A1;
            --blue-bg:#E0F2FE;
            --amber:#B45309;
            --amber-bg:#FEF3C7;
            --red:#DC2626;
            --red-bg:#FEE2E2;
        }
        body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}

        /* SIDEBAR */
        .sidebar{
            width:var(--sidebar-w);min-width:var(--sidebar-w);
            background:var(--secondary);
            display:flex;flex-direction:column;
            position:fixed;top:0;left:0;height:100vh;z-index:100;
        }
        .sidebar-brand{padding:20px 16px 16px;border-bottom:1px solid rgba(255,255,255,.07)}
        .sidebar-logo{display:flex;align-items:center;gap:8px}
        .sidebar-logo-dot{width:26px;height:26px;border-radius:7px;background:var(--primary);display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .sidebar-logo-dot svg{width:14px;height:14px;color:#fff}
        .sidebar-logo h1{font-family:'Bricolage Grotesque',sans-serif;font-size:17px;font-weight:800;color:#fff;letter-spacing:-.3px}
        .sidebar-sub{font-size:10px;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:1.2px;margin-top:4px;padding-left:34px}

        .sidebar-section{padding:10px 10px 4px;font-size:9.5px;font-weight:700;color:rgba(255,255,255,.2);text-transform:uppercase;letter-spacing:1.2px;margin-top:8px}
        .sidebar-nav{flex:1;padding:4px 10px 10px;overflow-y:auto}
        .sidebar-nav a{
            display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:7px;
            color:rgba(255,255,255,.5);text-decoration:none;font-size:13px;font-weight:500;
            transition:.12s;margin-bottom:1px;
        }
        .sidebar-nav a svg{width:16px;height:16px;flex-shrink:0;opacity:.7;transition:.12s}
        .sidebar-nav a:hover{color:rgba(255,255,255,.9);background:rgba(255,255,255,.06)}
        .sidebar-nav a:hover svg{opacity:.9}
        .sidebar-nav a.active{color:#fff;background:var(--primary)}
        .sidebar-nav a.active svg{opacity:1}

        .sidebar-bottom{padding:10px;border-top:1px solid rgba(255,255,255,.07)}
        .sidebar-user{display:flex;align-items:center;gap:8px;padding:8px 10px;margin-bottom:4px}
        .sidebar-avatar{width:28px;height:28px;border-radius:50%;background:var(--primary);color:#fff;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .sidebar-user-info{flex:1;min-width:0}
        .sidebar-user-name{font-size:12px;font-weight:600;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .sidebar-user-role{font-size:10px;color:rgba(255,255,255,.35)}
        .sidebar-logout-btn{
            display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:7px;
            color:rgba(255,255,255,.4);font-size:13px;font-weight:500;cursor:pointer;
            background:none;border:none;width:100%;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;
            transition:.12s;
        }
        .sidebar-logout-btn svg{width:16px;height:16px;flex-shrink:0}
        .sidebar-logout-btn:hover{color:rgba(255,255,255,.8);background:rgba(255,255,255,.06)}

        /* MAIN */
        .main-wrap{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh}
        .topbar{
            background:var(--white);border-bottom:1px solid var(--border);
            padding:0 28px;height:56px;display:flex;align-items:center;justify-content:space-between;
            position:sticky;top:0;z-index:50;
        }
        .topbar-left{display:flex;align-items:center;gap:12px}
        .topbar-breadcrumb{font-size:12px;color:var(--text-muted)}
        .topbar-breadcrumb strong{color:var(--text);font-weight:600}
        .topbar-right{display:flex;align-items:center;gap:10px}
        .topbar-icon-btn{
            width:34px;height:34px;border-radius:8px;border:1px solid var(--border);
            display:flex;align-items:center;justify-content:center;
            cursor:pointer;color:var(--text-muted);background:var(--white);
            transition:.12s;
        }
        .topbar-icon-btn svg{width:16px;height:16px}
        .topbar-icon-btn:hover{background:var(--bg);color:var(--text)}
        .topbar-sep{width:1px;height:20px;background:var(--border)}
        .topbar-user{display:flex;align-items:center;gap:8px;padding:4px 8px;border-radius:8px;cursor:pointer;transition:.12s}
        .topbar-user:hover{background:var(--bg)}
        .topbar-avatar{width:30px;height:30px;border-radius:50%;background:var(--primary);color:#fff;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center}
        .topbar-username{font-size:13px;font-weight:600}

        .page-content{padding:28px;flex:1}

        /* ALERTS */
        .alert{padding:11px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;font-weight:500;display:flex;align-items:center;gap:10px}
        .alert svg{width:16px;height:16px;flex-shrink:0}
        .alert-success{background:var(--green-bg);color:#14532D;border:1px solid #BBF7D0}
        .alert-error{background:var(--red-bg);color:#7F1D1D;border:1px solid #FECACA}

        /* STAT CARDS */
        .stat-card{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:20px 22px}
        .stat-card.primary-border{border-left:3px solid var(--primary)}
        .stat-icon{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:14px}
        .stat-icon svg{width:18px;height:18px}
        .stat-icon.orange{background:#FFF1E6;color:var(--primary)}
        .stat-icon.blue{background:#E0F2FE;color:var(--tertiary)}
        .stat-icon.green{background:#DCFCE7;color:var(--green)}
        .stat-icon.purple{background:#F3E8FF;color:#7C3AED}
        .stat-label{font-size:11px;font-weight:600;color:var(--text-muted);margin-bottom:4px;text-transform:uppercase;letter-spacing:.6px}
        .stat-value{font-family:'Bricolage Grotesque',sans-serif;font-size:32px;font-weight:800;color:var(--text)}

        /* CARD */
        .card{background:var(--white);border:1px solid var(--border);border-radius:10px}
        .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
        .card-header h3{font-size:13px;font-weight:700;color:var(--text)}
        .card-body{padding:0}

        /* TABLE */
        table{width:100%;border-collapse:collapse;font-size:13px}
        th{padding:9px 16px;text-align:left;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);border-bottom:1px solid var(--border);background:#FAFAFA}
        td{padding:12px 16px;border-bottom:1px solid var(--border);vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#FAFAFA}

        /* BADGES */
        .badge{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:99px;font-size:11px;font-weight:600}
        .badge-dot{width:6px;height:6px;border-radius:50%;background:currentColor;opacity:.7;flex-shrink:0}
        .badge-menunggu{background:var(--amber-bg);color:var(--amber)}
        .badge-ditemui{background:var(--blue-bg);color:var(--blue)}
        .badge-selesai{background:var(--green-bg);color:var(--green)}
        .tag{display:inline-block;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:600}

        /* BUTTONS */
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 16px;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:.12s;font-family:'Plus Jakarta Sans',sans-serif;line-height:1}
        .btn svg{width:14px;height:14px;flex-shrink:0}
        .btn-primary{background:var(--primary);color:#fff}
        .btn-primary:hover{background:var(--primary-dark)}
        .btn-secondary{background:var(--secondary);color:#fff}
        .btn-secondary:hover{background:#27272A}
        .btn-ghost{background:transparent;border:1.5px solid var(--border);color:var(--text)}
        .btn-ghost:hover{background:var(--bg)}
        .btn-blue{background:var(--blue-bg);color:var(--blue);border:1px solid #BAE6FD}
        .btn-blue:hover{background:#BAE6FD}
        .btn-sm{padding:5px 10px;font-size:12px}
        .btn-danger{background:var(--red-bg);color:var(--red);border:1.5px solid #FECACA}
        .btn-danger:hover{background:#FECACA}

        /* FORMS */
        .form-group{margin-bottom:16px}
        .form-label{display:block;font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px}
        .form-control{width:100%;padding:9px 12px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;color:var(--text);background:var(--white);transition:.12s;outline:none}
        .form-control:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(255,107,0,.1)}
        .form-error{font-size:12px;color:var(--red);margin-top:4px}

        /* PAGINATION */
        .pagination{display:flex;align-items:center;gap:4px;padding:14px 16px}
        .pagination span,.pagination a{display:flex;align-items:center;justify-content:center;min-width:30px;height:30px;border-radius:6px;font-size:12px;font-weight:500;text-decoration:none;color:var(--text-muted);border:1px solid var(--border);padding:0 6px}
        .pagination .active span{background:var(--primary);color:#fff;border-color:var(--primary)}
        .pagination a:hover{background:var(--bg)}
        .pagination-info{font-size:12px;color:var(--text-muted);padding:0 16px 14px}

        /* LAYOUT HELPERS */
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
        .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
        .flex{display:flex}.gap-2{gap:8px}.gap-3{gap:12px}.items-center{align-items:center}.justify-between{justify-content:space-between}.flex-1{flex:1}
        .mb-4{margin-bottom:16px}.mb-6{margin-bottom:24px}.mt-4{margin-top:16px}

        /* MODAL */
        .modal-backdrop{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:200;align-items:center;justify-content:center;padding:20px}
        .modal-backdrop.open{display:flex}
        .modal{background:#fff;border-radius:12px;padding:28px;width:100%;max-width:480px;box-shadow:0 24px 80px rgba(0,0,0,.18)}
        .modal-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px}
        .modal-title{font-family:'Bricolage Grotesque',sans-serif;font-size:16px;font-weight:700}
        .modal-close{width:28px;height:28px;border-radius:6px;border:1.5px solid var(--border);background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);flex-shrink:0}
        .modal-close svg{width:14px;height:14px}
        .modal-footer{display:flex;justify-content:flex-end;gap:8px;margin-top:20px;padding-top:16px;border-top:1px solid var(--border)}

        /* INPUT WITH ICON */
        .input-icon-wrap{position:relative}
        .input-icon-wrap .icon-left{position:absolute;left:11px;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none}
        .input-icon-wrap .icon-left svg{width:15px;height:15px}
        .input-icon-wrap .form-control{padding-left:34px}
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">
            <div class="sidebar-logo-dot">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z" />
                    <path fill-rule="evenodd" d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z" clip-rule="evenodd" />
                </svg>
            </div>
            <h1>NamuIn</h1>
        </div>
        <div class="sidebar-sub">Receptionist System</div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section">Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.buku-tamu.index') }}" class="{{ request()->routeIs('admin.buku-tamu.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" /></svg>
            Buku Tamu
        </a>
        <a href="{{ route('admin.kategori-tamu.index') }}" class="{{ request()->routeIs('admin.kategori-tamu.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" /></svg>
            Kategori Tamu
        </a>
        <a href="{{ route('admin.pegawai.index') }}" class="{{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
            Staf Sekolah
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
            Laporan
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" /></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <span class="topbar-breadcrumb">NamuIn &rsaquo; <strong>@yield('page-title', 'Dashboard')</strong></span>
        </div>
        <div class="topbar-right">
            <a href="{{ route('home') }}" target="_blank" class="topbar-icon-btn" title="Lihat Form Publik">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
            </a>
            <div class="topbar-sep"></div>
            <div class="topbar-user">
                <div class="topbar-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <span class="topbar-username">{{ explode(' ', auth()->user()->name)[0] }}</span>
            </div>
        </div>
    </header>

    <main class="page-content">
        @if(session('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
            {{ session('error') }}
        </div>
        @endif
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>
