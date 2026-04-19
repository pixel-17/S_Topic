<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'S_Topic') — ISTTA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sidebar-w: 260px;
            --primary:   #1a6b6b;
            --primary-lt:#e6f4f4;
            --accent:    #2a9d8f;
            --danger:    #e63946;
            --warn:      #f4a261;
            --success:   #2a9d4f;
            --text:      #1a1a2e;
            --muted:     #6b7280;
            --border:    #e5e7eb;
            --bg:        #f8fafb;
            --card:      #ffffff;
            --sidebar-bg:#0f2027;
            --sidebar-tx:#c9d6df;
            --sidebar-ac:#2a9d8f;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
 
        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w); background: var(--sidebar-bg);
            position: fixed; top: 0; left: 0; height: 100vh;
            display: flex; flex-direction: column; z-index: 100;
            overflow-y: auto;
        }
        .sidebar-logo {
            padding: 24px 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        .sidebar-logo h1 {
            font-size: 20px; font-weight: 700; color: #fff;
            letter-spacing: -.5px;
        }
        .sidebar-logo span { color: var(--sidebar-ac); }
        .sidebar-logo p { font-size: 11px; color: var(--sidebar-tx); margin-top: 2px; opacity: .6; }
 
        .sidebar-user {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-user .avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--sidebar-ac); display: flex; align-items: center;
            justify-content: center; font-size: 13px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .sidebar-user .info p { font-size: 13px; color: #fff; font-weight: 500; line-height: 1.2; }
        .sidebar-user .info span { font-size: 11px; color: var(--sidebar-tx); opacity: .7; text-transform: capitalize; }
 
        .sidebar-nav { padding: 12px 0; flex: 1; }
        .nav-label {
            font-size: 10px; font-weight: 600; letter-spacing: 1px;
            color: rgba(255,255,255,.3); text-transform: uppercase;
            padding: 12px 20px 6px;
        }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px; color: var(--sidebar-tx);
            font-size: 14px; font-weight: 400;
            transition: all .15s; border-left: 3px solid transparent;
        }
        .nav-item:hover { background: rgba(255,255,255,.05); color: #fff; }
        .nav-item.active {
            background: rgba(42,157,143,.15); color: #fff;
            border-left-color: var(--sidebar-ac); font-weight: 600;
        }
        .nav-item svg { width: 17px; height: 17px; opacity: .8; flex-shrink: 0; }
        .nav-item.active svg { opacity: 1; }
 
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,.07);
        }
 
        /* ── MAIN ── */
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            background: var(--card); border-bottom: 1px solid var(--border);
            padding: 0 28px; height: 60px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar h2 { font-size: 17px; font-weight: 600; color: var(--text); }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .badge-role {
            font-size: 11px; font-weight: 600; padding: 3px 10px;
            border-radius: 20px; text-transform: uppercase; letter-spacing: .5px;
        }
        .badge-admin { background: #fef3c7; color: #92400e; }
        .badge-enfermero { background: var(--primary-lt); color: var(--primary); }
 
        .content { padding: 28px; flex: 1; }
 
        /* ── CARDS ── */
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 24px; }
        .card-sm { padding: 16px 20px; }
 
        /* ── STATS ── */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 12px; padding: 20px 22px;
            display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 46px; height: 46px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-card .value { font-size: 28px; font-weight: 700; line-height: 1; }
        .stat-card .label { font-size: 13px; color: var(--muted); margin-top: 3px; }
 
        /* ── TABLE ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; padding: 10px 14px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: var(--muted); border-bottom: 1px solid var(--border); background: #fafafa; }
        td { padding: 12px 14px; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f9fafb; }
 
        /* ── BOTONES ── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; border: none; transition: all .15s; white-space: nowrap; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: #155858; }
        .btn-accent { background: var(--accent); color: #fff; }
        .btn-accent:hover { background: #238077; }
        .btn-outline { background: transparent; color: var(--text); border: 1px solid var(--border); }
        .btn-outline:hover { background: #f3f4f6; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-danger:hover { background: #c1121f; }
        .btn-sm { padding: 5px 11px; font-size: 13px; border-radius: 6px; }
        .btn-icon { padding: 6px; border-radius: 6px; display: inline-flex; }
 
        /* ── FORMS ── */
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 500; color: var(--text); margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 9px 12px; border: 1px solid var(--border);
            border-radius: 8px; font-size: 14px; font-family: 'DM Sans', sans-serif;
            background: #fff; color: var(--text); transition: border .15s;
        }
        .form-control:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(42,157,143,.1); }
        .form-control.is-invalid { border-color: var(--danger); }
        .invalid-feedback { font-size: 12px; color: var(--danger); margin-top: 4px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 20px; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 0 20px; }
        .col-span-2 { grid-column: span 2; }
        .col-span-3 { grid-column: span 3; }
 
        /* ── ALERTAS ── */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .alert-info    { background: var(--primary-lt); color: var(--primary); border: 1px solid #b2dfdb; }
 
        /* ── BADGES ── */
        .badge { font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-danger  { background: #fee2e2; color: #991b1b; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-primary { background: var(--primary-lt); color: var(--primary); }
        .badge-gray    { background: #f3f4f6; color: var(--muted); }
 
        /* ── PAGE HEADER ── */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .page-header h1 { font-size: 22px; font-weight: 700; }
        .page-header p  { font-size: 14px; color: var(--muted); margin-top: 2px; }
 
        /* ── DIVIDER ── */
        .section-title { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: var(--muted); margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid var(--border); }
 
        /* ── RECURRENTE BADGE ── */
        .recurrente-alert { display: inline-flex; align-items: center; gap: 6px; background: #fff3e0; color: #e65100; border: 1px solid #ffcc80; border-radius: 8px; padding: 8px 14px; font-size: 13px; font-weight: 600; }
 
        /* ── PRINT ── */
        @media print {
            .sidebar, .topbar, .no-print { display: none !important; }
            .main { margin-left: 0 !important; }
            .content { padding: 0 !important; }
            .card { border: none !important; box-shadow: none !important; }
        }
    </style>
</head>
<body>
 
{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <h1>S<span>_</span>Topic</h1>
        <p>ISTTA — Gestión del Tópico</p>
    </div>
 
    <div class="sidebar-user">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div class="info">
            <p>{{ auth()->user()->name }}</p>
            <span>{{ auth()->user()->rol }}</span>
        </div>
    </div>
 
    <nav class="sidebar-nav">
        <div class="nav-label">Principal</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>
 
        <div class="nav-label">Atención</div>
        <a href="{{ route('atenciones.create') }}" class="nav-item {{ request()->routeIs('atenciones.create') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
            Nueva Atención
        </a>
        <a href="{{ route('atenciones.index') }}" class="nav-item {{ request()->routeIs('atenciones.index') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Atenciones
        </a>
 
        <div class="nav-label">Estudiantes</div>
        <a href="{{ route('estudiantes.index') }}" class="nav-item {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Estudiantes
        </a>
 
        <div class="nav-label">Reportes</div>
        <a href="{{ route('reportes.index') }}" class="nav-item {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Reportes
        </a>
 
        @if(auth()->user()->isAdmin())
        <div class="nav-label">Administración</div>
        <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Usuarios
        </a>
        @endif
    </nav>
 
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="width:100%;background:none;border:none;cursor:pointer;color:rgba(201,214,223,.6);font-family:'DM Sans',sans-serif;">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="width:17px;height:17px;"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>
 
{{-- MAIN --}}
<div class="main">
    <div class="topbar">
        <h2>@yield('page-title', 'Dashboard')</h2>
        <div class="topbar-right">
            <span class="badge-role {{ auth()->user()->isAdmin() ? 'badge-admin' : 'badge-enfermero' }}">
                {{ auth()->user()->isAdmin() ? 'Administrador' : 'Enfermera' }}
            </span>
        </div>
    </div>
 
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif
 
        @yield('content')
    </div>
</div>
 
</body>
</html>
