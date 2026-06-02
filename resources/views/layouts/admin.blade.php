<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NamuIn') — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --sidebar-w:200px;
            --orange:#f97316;
            --orange-dark:#ea580c;
            --dark:#1a1a2e;
            --dark2:#16213e;
            --text:#1e293b;
            --text-muted:#64748b;
            --border:#e2e8f0;
            --bg:#f8fafc;
            --white:#fff;
            --green:#10b981;
            --blue:#3b82f6;
            --yellow:#f59e0b;
            --red:#ef4444;
        }
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}

        .sidebar{
            width:var(--sidebar-w);min-width:var(--sidebar-w);
            background:var(--dark);color:#fff;display:flex;flex-direction:column;
            position:fixed;top:0;left:0;height:100vh;z-index:100;
        }
        .sidebar-brand{padding:20px 16px 8px;border-bottom:1px solid rgba(255,255,255,.08)}
        .sidebar-brand h1{font-size:18px;font-weight:700;color:#fff;letter-spacing:.5px}
        .sidebar-brand p{font-size:10px;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;margin-top:2px}
        .sidebar-nav{flex:1;padding:12px 0}
        .sidebar-nav a{
            display:flex;align-items:center;gap:10px;padding:10px 16px;
            color:#94a3b8;text-decoration:none;font-size:13px;font-weight:500;
            transition:.15s;border-radius:0;
        }
        .sidebar-nav a:hover{color:#fff;background:rgba(255,255,255,.06)}
        .sidebar-nav a.active{color:#fff;background:var(--orange);border-radius:0}
        .sidebar-nav .icon{width:16px;text-align:center;font-style:normal}
        .sidebar-logout{padding:12px 16px;border-top:1px solid rgba(255,255,255,.08)}
        .sidebar-logout form button{
            display:flex;align-items:center;gap:10px;
            background:none;border:none;color:#94a3b8;font-size:13px;
            font-weight:500;cursor:pointer;padding:10px 0;width:100%;
            font-family:inherit;transition:.15s;
        }
        .sidebar-logout form button:hover{color:#fff}

        .main-wrap{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh}
        .topbar{
            background:var(--white);border-bottom:1px solid var(--border);
            padding:0 28px;height:56px;display:flex;align-items:center;justify-content:space-between;
            position:sticky;top:0;z-index:50;
        }
        .topbar-title{font-size:16px;font-weight:600}
        .topbar-right{display:flex;align-items:center;gap:12px}
        .topbar-avatar{width:34px;height:34px;border-radius:50%;background:var(--orange);color:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700}
        .topbar-bell{font-size:18px;cursor:pointer;color:var(--text-muted)}

        .page-content{padding:28px;flex:1}

        .alert{padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;font-weight:500}
        .alert-success{background:#d1fae5;color:#065f46;border:1px solid #a7f3d0}
        .alert-error{background:#fee2e2;color:#991b1b;border:1px solid #fca5a5}

        .stat-card{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:20px 24px}
        .stat-card.orange-border{border-left:3px solid var(--orange)}
        .stat-label{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.8px;color:var(--text-muted);margin-bottom:10px;display:flex;align-items:center;justify-content:space-between}
        .stat-value{font-size:32px;font-weight:700;color:var(--text)}

        .card{background:var(--white);border:1px solid var(--border);border-radius:10px}
        .card-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
        .card-header h3{font-size:14px;font-weight:600}
        .card-body{padding:0}

        table{width:100%;border-collapse:collapse;font-size:13px}
        th{padding:10px 16px;text-align:left;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.6px;color:var(--text-muted);border-bottom:1px solid var(--border)}
        td{padding:12px 16px;border-bottom:1px solid var(--border);vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#f8fafc}

        .badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:600}
        .badge::before{content:'';width:6px;height:6px;border-radius:50%;background:currentColor;opacity:.7}
        .badge-menunggu{background:#fef3c7;color:#92400e}
        .badge-ditemui{background:#dbeafe;color:#1e40af}
        .badge-selesai{background:#d1fae5;color:#065f46}

        .tag{display:inline-block;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px}

        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;border:none;text-decoration:none;transition:.15s;font-family:inherit}
        .btn-primary{background:var(--orange);color:#fff}
        .btn-primary:hover{background:var(--orange-dark)}
        .btn-ghost{background:transparent;border:1px solid var(--border);color:var(--text)}
        .btn-ghost:hover{background:var(--bg)}
        .btn-sm{padding:5px 12px;font-size:12px}
        .btn-danger{background:#fee2e2;color:var(--red);border:1px solid #fca5a5}
        .btn-danger:hover{background:#fca5a5}

        .form-group{margin-bottom:16px}
        .form-label{display:block;font-size:12px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px}
        .form-control{width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:7px;font-size:13px;font-family:inherit;color:var(--text);background:var(--white);transition:.15s;outline:none}
        .form-control:focus{border-color:var(--orange);box-shadow:0 0 0 3px rgba(249,115,22,.1)}
        .form-error{font-size:12px;color:var(--red);margin-top:4px}

        .pagination{display:flex;align-items:center;gap:4px;padding:14px 16px}
        .pagination span,.pagination a{display:flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:6px;font-size:12px;font-weight:500;text-decoration:none;color:var(--text-muted);border:1px solid var(--border)}
        .pagination .active span{background:var(--orange);color:#fff;border-color:var(--orange)}
        .pagination a:hover{background:var(--bg)}
        .pagination-info{font-size:12px;color:var(--text-muted);padding:0 16px 14px}

        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
        .flex{display:flex}.gap-2{gap:8px}.gap-3{gap:12px}.items-center{align-items:center}.justify-between{justify-content:space-between}.flex-1{flex:1}
        .mb-4{margin-bottom:16px}.mb-6{margin-bottom:24px}.mt-4{margin-top:16px}

        .modal-backdrop{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:200;align-items:center;justify-content:center}
        .modal-backdrop.open{display:flex}
        .modal{background:#fff;border-radius:12px;padding:28px;width:100%;max-width:480px;box-shadow:0 20px 60px rgba(0,0,0,.2)}
        .modal-title{font-size:16px;font-weight:700;margin-bottom:20px}
        .modal-footer{display:flex;justify-content:flex-end;gap:8px;margin-top:20px}

        @media(max-width:768px){
            .sidebar{transform:translateX(-100%)}
            .main-wrap{margin-left:0}
        }
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-brand">
        <h1>NamuIn</h1>
        <p>Receptionist</p>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="icon">⊞</i> Dashboard
        </a>
        <a href="{{ route('admin.buku-tamu.index') }}" class="{{ request()->routeIs('admin.buku-tamu.*') ? 'active' : '' }}">
            <i class="icon">📋</i> Buku Tamu
        </a>
        <a href="{{ route('admin.kategori-tamu.index') }}" class="{{ request()->routeIs('admin.kategori-tamu.*') ? 'active' : '' }}">
            <i class="icon">🏷</i> Kategori Tamu
        </a>
        <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <i class="icon">📊</i> Laporan
        </a>
    </nav>
    <div class="sidebar-logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                <i class="icon">↩</i> Keluar
            </button>
        </form>
    </div>
</aside>

<div class="main-wrap">
    <header class="topbar">
        <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        <div class="topbar-right">
            <span class="topbar-bell">🔔</span>
            <div class="topbar-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
        </div>
    </header>
    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>
