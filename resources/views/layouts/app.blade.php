<!DOCTYPE html>
<html lang="es" data-tema="{{ session('tema','light') }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title','S_Topic') — ISTTA</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
@vite(['resources/css/app.css','resources/js/app.js'])
<style>
/* ══ TOKENS POR TEMA ══ */
[data-tema="light"]{
    --primary:#1a6b6b;--primary-lt:#e6f4f4;--primary-dk:#134f4f;
    --accent:#2a9d8f;--accent-lt:#d4edea;
    --danger:#e63946;--danger-lt:#fde8ea;
    --warn:#f4a261;--warn-lt:#fef0e6;
    --success:#2a9d4f;--success-lt:#d4f0de;
    --text:#111827;--text2:#4b5563;--muted:#9ca3af;
    --border:#e5e7eb;--border2:#d1d5db;
    --bg:#f1f5f9;--card:#fff;--card2:#f8fafc;
    --sidebar-bg:#0d1b2a;--sidebar-tx:#94a3b8;--sidebar-ac:#2a9d8f;
    --topbar-bg:#fff;
}
[data-tema="dark"]{
    --primary:#2a9d8f;--primary-lt:rgba(42,157,143,.15);--primary-dk:#228b7e;
    --accent:#2a9d8f;--accent-lt:rgba(42,157,143,.12);
    --danger:#f87171;--danger-lt:rgba(248,113,113,.12);
    --warn:#fbbf24;--warn-lt:rgba(251,191,36,.12);
    --success:#4ade80;--success-lt:rgba(74,222,128,.12);
    --text:#f1f5f9;--text2:#94a3b8;--muted:#64748b;
    --border:#1e293b;--border2:#334155;
    --bg:#0f172a;--card:#1e293b;--card2:#263248;
    --sidebar-bg:#0a1628;--sidebar-tx:#94a3b8;--sidebar-ac:#2a9d8f;
    --topbar-bg:#1e293b;
}
[data-tema="blue"]{
    --primary:#1e40af;--primary-lt:#dbeafe;--primary-dk:#1e3a8a;
    --accent:#3b82f6;--accent-lt:#eff6ff;
    --danger:#ef4444;--danger-lt:#fef2f2;
    --warn:#f59e0b;--warn-lt:#fffbeb;
    --success:#10b981;--success-lt:#d1fae5;
    --text:#1e293b;--text2:#475569;--muted:#94a3b8;
    --border:#e2e8f0;--border2:#cbd5e1;
    --bg:#f0f4ff;--card:#fff;--card2:#f8faff;
    --sidebar-bg:#1e1b4b;--sidebar-tx:#a5b4fc;--sidebar-ac:#818cf8;
    --topbar-bg:#fff;
}

*{box-sizing:border-box;margin:0;padding:0;transition:background-color .2s,border-color .2s,color .15s;}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh;font-size:14px;line-height:1.5;}
a{text-decoration:none;color:inherit;}
::selection{background:var(--primary-lt);color:var(--primary);}
::-webkit-scrollbar{width:5px;height:5px;}
::-webkit-scrollbar-thumb{background:var(--border2);border-radius:10px;}

/* ── SIDEBAR ── */
.sidebar{
    width:260px;background:var(--sidebar-bg);
    position:fixed;top:0;left:0;height:100vh;
    display:flex;flex-direction:column;z-index:200;overflow-y:auto;
    transition:transform .28s cubic-bezier(.4,0,.2,1);
}
.sb-logo{padding:20px 16px 14px;border-bottom:1px solid rgba(255,255,255,.06);}
.sb-logo h1{font-size:20px;font-weight:700;color:#fff;letter-spacing:-.5px;display:flex;align-items:center;gap:8px;}
.sb-logo .dot{width:8px;height:8px;background:var(--sidebar-ac);border-radius:50%;animation:pulse 2s ease infinite;flex-shrink:0;}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(42,157,143,.4);}50%{box-shadow:0 0 0 6px rgba(42,157,143,0);}}
.sb-logo p{font-size:11px;color:var(--sidebar-tx);opacity:.55;margin-top:2px;}

.sb-user{padding:12px 16px;border-bottom:1px solid rgba(255,255,255,.06);display:flex;align-items:center;gap:10px;}
.sb-av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--sidebar-ac),var(--primary));display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#fff;flex-shrink:0;}
.sb-user .info p{font-size:13px;color:#fff;font-weight:500;line-height:1.2;}
.sb-user .info span{font-size:11px;color:var(--sidebar-tx);opacity:.6;text-transform:capitalize;}

.nav-label{font-size:10px;font-weight:700;letter-spacing:1.2px;color:rgba(255,255,255,.22);text-transform:uppercase;padding:14px 16px 5px;}
.nav-item{display:flex;align-items:center;gap:10px;padding:9px 16px;color:var(--sidebar-tx);font-size:13.5px;font-weight:400;transition:all .15s;border-left:3px solid transparent;border:none;background:none;width:100%;font-family:'DM Sans',sans-serif;cursor:pointer;border-left:3px solid transparent;}
.nav-item:hover{background:rgba(255,255,255,.05);color:#e2e8f0;}
.nav-item.active{background:rgba(42,157,143,.15);color:#fff;border-left-color:var(--sidebar-ac);font-weight:600;}
.nav-item svg{width:16px;height:16px;flex-shrink:0;opacity:.7;}
.nav-item.active svg,.nav-item:hover svg{opacity:1;}

.sb-footer{padding:12px 16px;border-top:1px solid rgba(255,255,255,.06);margin-top:auto;}

/* ── TOPBAR ── */
.main{margin-left:260px;flex:1;display:flex;flex-direction:column;min-height:100vh;}
.topbar{background:var(--topbar-bg);border-bottom:1px solid var(--border);padding:0 24px;height:58px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;box-shadow:0 1px 3px rgba(0,0,0,.06);}
.topbar-title{font-size:16px;font-weight:600;color:var(--text);}
.topbar-right{display:flex;align-items:center;gap:8px;}
.badge-role{font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px;text-transform:uppercase;letter-spacing:.5px;}
.badge-admin{background:#fef3c7;color:#92400e;}
.badge-enfermero{background:var(--primary-lt);color:var(--primary);}

.hamburger{display:none;align-items:center;justify-content:center;width:36px;height:36px;border:1px solid var(--border);border-radius:7px;cursor:pointer;background:none;color:var(--text);}

.content{padding:24px;flex:1;}

/* ── TOAST v3 ── */
#toast-container{position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;width:340px;}
.toast{
    background:var(--card);border-radius:12px;
    box-shadow:0 10px 40px rgba(0,0,0,.15),0 2px 8px rgba(0,0,0,.1);
    padding:0;overflow:hidden;
    display:flex;align-items:stretch;
    pointer-events:all;
    transform:translateX(calc(100% + 24px));opacity:0;
    transition:transform .4s cubic-bezier(.34,1.56,.64,1),opacity .3s;
    border:1px solid var(--border);
}
.toast.show{transform:translateX(0);opacity:1;}
.toast.hide{transform:translateX(calc(100% + 24px));opacity:0;transition:transform .3s ease,opacity .25s;}
.toast-stripe{width:5px;flex-shrink:0;}
.toast-inner{display:flex;align-items:flex-start;gap:10px;padding:14px 14px 14px 12px;flex:1;}
.toast-icon-wrap{width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
.toast-body{flex:1;}
.toast-title{font-size:13.5px;font-weight:600;color:var(--text);line-height:1.3;}
.toast-msg{font-size:12.5px;color:var(--text2);margin-top:2px;line-height:1.4;}
.toast-close{color:var(--muted);cursor:pointer;font-size:18px;line-height:1;padding:2px 4px;flex-shrink:0;background:none;border:none;font-family:inherit;}
.toast-close:hover{color:var(--text);}
.toast-progress{height:3px;background:rgba(0,0,0,.08);position:relative;overflow:hidden;}
.toast-progress-bar{position:absolute;left:0;top:0;height:100%;animation:progress 4.5s linear forwards;}
@keyframes progress{from{width:100%;}to{width:0%;}}

.t-success .toast-stripe,.t-success .toast-progress-bar{background:var(--success);}
.t-success .toast-icon-wrap{background:var(--success-lt);}
.t-danger  .toast-stripe,.t-danger  .toast-progress-bar{background:var(--danger);}
.t-danger  .toast-icon-wrap{background:var(--danger-lt);}
.t-warning .toast-stripe,.t-warning .toast-progress-bar{background:var(--warn);}
.t-warning .toast-icon-wrap{background:var(--warn-lt);}
.t-info    .toast-stripe,.t-info    .toast-progress-bar{background:var(--accent);}
.t-info    .toast-icon-wrap{background:var(--accent-lt);}

/* ── CARDS ── */
.card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:22px;box-shadow:0 1px 3px rgba(0,0,0,.06);}
.card-sm{padding:14px 18px;}

/* ── STATS ── */
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:14px;margin-bottom:22px;}
.stat-card{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:18px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 3px rgba(0,0,0,.06);transition:transform .2s,box-shadow .2s;}
.stat-card:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(0,0,0,.1);}
.stat-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:19px;flex-shrink:0;}
.stat-card .value{font-size:28px;font-weight:700;line-height:1;}
.stat-card .label{font-size:12px;color:var(--muted);margin-top:3px;}

/* ── TABLES ── */
.table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;}
table{width:100%;border-collapse:collapse;font-size:13.5px;}
th{text-align:left;padding:9px 13px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--muted);border-bottom:1px solid var(--border);background:var(--card2);white-space:nowrap;}
td{padding:11px 13px;border-bottom:1px solid var(--border);vertical-align:middle;}
tr:last-child td{border-bottom:none;}
tbody tr{transition:background .1s;}
tbody tr:hover td{background:var(--card2);}
.num-col{font-family:'DM Mono',monospace;font-size:12px;color:var(--muted);font-weight:500;width:40px;}

/* ── BOTONES ── */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 15px;border-radius:7px;font-size:13.5px;font-weight:500;cursor:pointer;border:none;transition:all .15s;white-space:nowrap;font-family:'DM Sans',sans-serif;line-height:1;}
.btn:active{transform:scale(.97);}
.btn-primary{background:var(--primary);color:#fff;}
.btn-primary:hover{background:var(--primary-dk);}
.btn-accent{background:var(--accent);color:#fff;}
.btn-accent:hover{filter:brightness(1.1);}
.btn-outline{background:transparent;color:var(--text);border:1px solid var(--border2);}
.btn-outline:hover{background:var(--card2);border-color:var(--muted);}
.btn-danger{background:var(--danger);color:#fff;}
.btn-danger:hover{filter:brightness(1.1);}
.btn-sm{padding:5px 10px;font-size:12px;border-radius:6px;}

/* ── FORMS ── */
.form-group{margin-bottom:16px;}
.form-group label{display:block;font-size:13px;font-weight:500;color:var(--text);margin-bottom:5px;}
.form-control{width:100%;padding:9px 12px;border:1.5px solid var(--border2);border-radius:7px;font-size:13.5px;font-family:'DM Sans',sans-serif;background:var(--card);color:var(--text);transition:border .15s,box-shadow .15s;}
.form-control:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 3px rgba(42,157,143,.1);}
.form-control:disabled{background:var(--card2);color:var(--muted);cursor:not-allowed;}
.form-control.is-invalid{border-color:var(--danger);}
select.form-control{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;padding-right:30px;appearance:none;}
.invalid-feedback{font-size:12px;color:var(--danger);margin-top:4px;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:0 18px;}
.col-span-2{grid-column:span 2;}

/* ── BADGES ── */
.badge{font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;display:inline-flex;align-items:center;gap:3px;}
.badge-success{background:var(--success-lt);color:var(--success);}
.badge-danger{background:var(--danger-lt);color:var(--danger);}
.badge-warning{background:var(--warn-lt);color:#c2410c;}
.badge-primary{background:var(--primary-lt);color:var(--primary);}
.badge-gray{background:var(--card2);color:var(--muted);}

/* ── PAGE HEADER ── */
.page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap;}
.page-header h1{font-size:20px;font-weight:700;line-height:1.2;}
.page-header p{font-size:13px;color:var(--muted);margin-top:3px;}
.section-title{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);margin-bottom:14px;padding-bottom:8px;border-bottom:1px solid var(--border);}

/* ── RECURRENTE ── */
.recurrente-alert{display:inline-flex;align-items:center;gap:8px;background:var(--warn-lt);color:#c2410c;border:1px solid #fdba74;border-radius:9px;padding:10px 16px;font-size:13px;font-weight:600;animation:pulse-warn 2.5s ease infinite;}
@keyframes pulse-warn{0%,100%{box-shadow:0 0 0 0 rgba(244,162,97,.3);}50%{box-shadow:0 0 0 6px rgba(244,162,97,0);}}

/* ── MODAL CONFIGURACIONES ── */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:500;backdrop-filter:blur(4px);}
.modal-overlay.show{display:flex;align-items:center;justify-content:center;}
.modal{background:var(--card);border-radius:16px;padding:28px;width:420px;max-width:95vw;box-shadow:0 20px 60px rgba(0,0,0,.2);animation:modal-in .25s ease;}
@keyframes modal-in{from{transform:scale(.95);opacity:0;}to{transform:scale(1);opacity:1;}}
.modal h2{font-size:18px;font-weight:700;margin-bottom:4px;}
.modal p{font-size:13px;color:var(--muted);margin-bottom:22px;}
.tema-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:22px;}
.tema-btn{border:2px solid var(--border);border-radius:10px;padding:14px 10px;cursor:pointer;text-align:center;transition:all .2s;background:var(--card);}
.tema-btn:hover{border-color:var(--accent);}
.tema-btn.active{border-color:var(--accent);background:var(--accent-lt);}
.tema-btn .tema-preview{width:100%;height:32px;border-radius:6px;margin-bottom:8px;}
.tema-btn span{font-size:12px;font-weight:600;color:var(--text);}

/* ── IMC ── */
.imc-card{background:linear-gradient(135deg,var(--primary-lt),var(--accent-lt));border:1px solid var(--border2);border-radius:9px;padding:14px;margin-top:10px;}

/* ── RESPONSIVE ── */
@media(max-width:768px){
    .sidebar{transform:translateX(-100%);}
    .sidebar.open{transform:translateX(0);}
    .main{margin-left:0;}
    .content{padding:16px;}
    .stats-grid{grid-template-columns:1fr 1fr;}
    .form-grid{grid-template-columns:1fr;}
    .col-span-2{grid-column:span 1;}
    .page-header{flex-direction:column;}
    .hamburger{display:flex!important;}
}
.overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:199;}
.overlay.show{display:block;}

@media print{.sidebar,.topbar,.no-print{display:none!important;}.main{margin-left:0!important;}.content{padding:0!important;}}
</style>
</head>
<body>

<div id="overlay" class="overlay" onclick="closeSidebar()"></div>
<div id="toast-container"></div>

{{-- MODAL CONFIGURACIONES --}}
<div class="modal-overlay" id="modal-config" onclick="if(event.target===this)closeConfig()">
<div class="modal">
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:4px;">
        <h2>⚙️ Configuraciones</h2>
        <button onclick="closeConfig()" style="background:none;border:none;cursor:pointer;font-size:20px;color:var(--muted);line-height:1;">×</button>
    </div>
    <p>Personaliza la apariencia del sistema</p>

    <div class="section-title" style="margin-bottom:12px;">Tema de color</div>
    <form method="POST" action="{{ route('perfil.tema') }}" id="forma-tema">
    @csrf @method('PUT')
    <input type="hidden" name="tema" id="input-tema" value="{{ session('tema','light') }}">
    <div class="tema-grid">
        <div class="tema-btn {{ session('tema','light')==='light' ? 'active' : '' }}" onclick="selTema('light')">
            <div class="tema-preview" style="background:linear-gradient(135deg,#1a6b6b,#2a9d8f);"></div>
            <span>Claro</span>
        </div>
        <div class="tema-btn {{ session('tema','light')==='dark' ? 'active' : '' }}" onclick="selTema('dark')">
            <div class="tema-preview" style="background:linear-gradient(135deg,#0f172a,#1e293b);"></div>
            <span>Oscuro</span>
        </div>
        <div class="tema-btn {{ session('tema','light')==='blue' ? 'active' : '' }}" onclick="selTema('blue')">
            <div class="tema-preview" style="background:linear-gradient(135deg,#1e40af,#3b82f6);"></div>
            <span>Azul</span>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;">Aplicar tema</button>
    </form>

    <div class="section-title" style="margin-top:20px;margin-bottom:12px;">Contraseña</div>
    <a href="{{ route('perfil.edit') }}" class="btn btn-outline" style="width:100%;justify-content:center;" onclick="closeConfig()">
        🔒 Cambiar contraseña
    </a>

    <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border);font-size:12px;color:var(--muted);text-align:center;">
        S_Topic v2.0 · ISTTA "Túpac Amaru"
    </div>
</div>
</div>

{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">
    <div class="sb-logo">
        <h1><span class="dot"></span> S_Topic</h1>
        <p>ISTTA — Tópico</p>
    </div>
    <div class="sb-user">
        <div class="sb-av">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
        <div class="info">
            <p>{{ auth()->user()->name }}</p>
            <span>{{ auth()->user()->rol }}</span>
        </div>
    </div>
    <nav style="flex:1;">
        <div class="nav-label">Principal</div>
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard')?'active':'' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <div class="nav-label">Atención</div>
        <a href="{{ route('atenciones.create') }}" class="nav-item {{ request()->routeIs('atenciones.create')?'active':'' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Nueva Atención
        </a>
        <a href="{{ route('atenciones.index') }}" class="nav-item {{ request()->routeIs('atenciones.index')?'active':'' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Atenciones
        </a>

        <div class="nav-label">Estudiantes</div>
        <a href="{{ route('estudiantes.index') }}" class="nav-item {{ request()->routeIs('estudiantes.*')?'active':'' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Estudiantes
        </a>

        <div class="nav-label">Análisis</div>
        <a href="{{ route('reportes.index') }}" class="nav-item {{ request()->routeIs('reportes.*')?'active':'' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Reportes
        </a>

        @if(auth()->user()->isAdmin())
        <div class="nav-label">Admin</div>
        <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*')?'active':'' }}">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Usuarios
        </a>
        @endif
    </nav>

    <div class="sb-footer">
        <button class="nav-item" onclick="openConfig()" style="color:rgba(148,163,184,.7);">
            <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
            Configuraciones
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="color:rgba(148,163,184,.5);">
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="main">
    <div class="topbar">
        <div style="display:flex;align-items:center;gap:10px;">
            <button class="hamburger" id="hamburger" onclick="toggleSidebar()">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <span class="topbar-title">@yield('page-title','Dashboard')</span>
        </div>
        <div class="topbar-right">
            <span class="badge-role {{ auth()->user()->isAdmin()?'badge-admin':'badge-enfermero' }}">
                {{ auth()->user()->isAdmin()?'Admin':'Enfermera' }}
            </span>
        </div>
    </div>
    <div class="content">@yield('content')</div>
</div>

<script>
// ── TOASTS v3 ──
function showToast(type, title, msg='') {
    const icons={success:'✅',danger:'❌',warning:'⚠️',info:'ℹ️'};
    const c=document.getElementById('toast-container');
    const t=document.createElement('div');
    t.className=`toast t-${type}`;
    t.innerHTML=`
        <div class="toast-stripe"></div>
        <div style="flex:1;display:flex;flex-direction:column;">
            <div class="toast-inner">
                <div class="toast-icon-wrap">${icons[type]||'ℹ️'}</div>
                <div class="toast-body">
                    <div class="toast-title">${title}</div>
                    ${msg?`<div class="toast-msg">${msg}</div>`:''}
                </div>
                <button class="toast-close" onclick="dismissToast(this.closest('.toast'))">×</button>
            </div>
            <div class="toast-progress"><div class="toast-progress-bar"></div></div>
        </div>`;
    c.appendChild(t);
    requestAnimationFrame(()=>t.classList.add('show'));
    const timer=setTimeout(()=>dismissToast(t),4600);
    t._timer=timer;
}
function dismissToast(t){
    clearTimeout(t._timer);
    t.classList.remove('show');t.classList.add('hide');
    setTimeout(()=>t.remove(),350);
}

@if(session('success')) showToast('success','Éxito',@json(session('success'))); @endif
@if(session('error'))   showToast('danger','Error',@json(session('error'))); @endif
@if($errors->any())     showToast('danger','Revisa el formulario','Hay {{ $errors->count() }} campo(s) con error.'); @endif

// ── SIDEBAR ──
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('show');
}
function closeSidebar(){
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('show');
}

// ── CONFIGURACIONES ──
function openConfig(){document.getElementById('modal-config').classList.add('show');}
function closeConfig(){document.getElementById('modal-config').classList.remove('show');}
function selTema(t){
    document.getElementById('input-tema').value=t;
    document.querySelectorAll('.tema-btn').forEach(b=>b.classList.remove('active'));
    event.currentTarget.classList.add('active');
}
</script>
</body>
</html>
