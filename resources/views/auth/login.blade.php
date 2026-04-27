<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>S_Topic — Iniciar Sesión</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
@vite(['resources/css/app.css','resources/js/app.js'])
<style>
:root{
    --primary:#1a6b6b;--accent:#2a9d8f;--danger:#e63946;
    --text:#111827;--muted:#6b7280;--border:#e5e7eb;
    --bg:#f1f5f9;--card:#fff;
}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'DM Sans',sans-serif;min-height:100vh;background:var(--bg);display:flex;}

/* ── Split layout ── */
.login-wrap{display:flex;width:100%;min-height:100vh;}

/* Panel izquierdo decorativo */
.login-left{
    flex:1;background:linear-gradient(145deg,#0d1b2a 0%,#1a3a3a 50%,#0f2f2f 100%);
    display:flex;flex-direction:column;justify-content:center;align-items:center;
    padding:48px;position:relative;overflow:hidden;
}
.login-left::before{
    content:'';position:absolute;inset:0;
    background:radial-gradient(ellipse at 30% 20%,rgba(42,157,143,.25) 0%,transparent 60%),
               radial-gradient(ellipse at 70% 80%,rgba(26,107,107,.3) 0%,transparent 55%);
}
.login-left-content{position:relative;z-index:1;text-align:center;max-width:380px;}
.brand{display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:40px;}
.brand-dot{width:12px;height:12px;background:#2a9d8f;border-radius:50%;animation:pulse 2s ease infinite;}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(42,157,143,.5);}50%{box-shadow:0 0 0 10px rgba(42,157,143,0);}}
.brand-name{font-size:32px;font-weight:700;color:#fff;letter-spacing:-1px;}
.brand-name span{color:#2a9d8f;}
.left-title{font-size:22px;font-weight:600;color:#fff;line-height:1.3;margin-bottom:14px;}
.left-sub{font-size:14px;color:rgba(255,255,255,.5);line-height:1.7;}
.features{margin-top:40px;display:flex;flex-direction:column;gap:14px;text-align:left;}
.feature{display:flex;align-items:flex-start;gap:12px;}
.feature-icon{width:32px;height:32px;background:rgba(42,157,143,.15);border:1px solid rgba(42,157,143,.3);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;}
.feature-text p{font-size:13px;font-weight:600;color:#e2e8f0;}
.feature-text span{font-size:12px;color:rgba(255,255,255,.4);}

/* Círculos decorativos */
.deco{position:absolute;border-radius:50%;border:1px solid rgba(42,157,143,.12);}
.deco1{width:300px;height:300px;top:-80px;right:-80px;}
.deco2{width:200px;height:200px;bottom:-50px;left:-60px;}
.deco3{width:150px;height:150px;bottom:100px;right:-40px;border-color:rgba(42,157,143,.08);}

/* Panel derecho — formulario */
.login-right{
    width:460px;flex-shrink:0;background:var(--card);
    display:flex;flex-direction:column;justify-content:center;
    padding:56px 48px;
    box-shadow:-8px 0 40px rgba(0,0,0,.08);
}
.login-header{margin-bottom:36px;}
.login-header h1{font-size:26px;font-weight:700;color:var(--text);line-height:1.2;}
.login-header p{font-size:14px;color:var(--muted);margin-top:6px;}

.form-group{margin-bottom:18px;}
.form-group label{display:block;font-size:13px;font-weight:600;color:var(--text);margin-bottom:7px;}
.input-wrap{position:relative;}
.input-wrap .input-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;}
.form-control{
    width:100%;padding:11px 13px 11px 40px;
    border:1.5px solid var(--border);border-radius:9px;
    font-size:14px;font-family:'DM Sans',sans-serif;
    color:var(--text);background:#fff;
    transition:border .15s,box-shadow .15s;
}
.form-control:focus{outline:none;border-color:#2a9d8f;box-shadow:0 0 0 3px rgba(42,157,143,.12);}
.form-control.is-invalid{border-color:var(--danger);}
.invalid-msg{font-size:12px;color:var(--danger);margin-top:5px;display:flex;align-items:center;gap:4px;}

.toggle-pw{position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:var(--muted);padding:4px;}
.toggle-pw:hover{color:var(--text);}

.remember-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;}
.remember-row label{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--muted);}
.remember-row input[type=checkbox]{width:15px;height:15px;accent-color:#2a9d8f;}

.btn-login{
    width:100%;padding:13px;border:none;border-radius:9px;
    background:linear-gradient(135deg,#1a6b6b,#2a9d8f);
    color:#fff;font-size:15px;font-weight:600;
    cursor:pointer;font-family:'DM Sans',sans-serif;
    transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px;
    box-shadow:0 4px 15px rgba(42,157,143,.35);
}
.btn-login:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(42,157,143,.45);}
.btn-login:active{transform:scale(.98);}
.btn-login:disabled{opacity:.7;cursor:not-allowed;transform:none;}

.login-footer{margin-top:32px;padding-top:24px;border-top:1px solid var(--border);text-align:center;font-size:12px;color:var(--muted);}

@media(max-width:768px){
    .login-left{display:none;}
    .login-right{width:100%;padding:40px 24px;}
}
</style>
</head>
<body>
<div class="login-wrap">

    {{-- Panel izquierdo --}}
    <div class="login-left">
        <div class="deco deco1"></div>
        <div class="deco deco2"></div>
        <div class="deco deco3"></div>
        <div class="login-left-content">
            <div class="brand">
                <div class="brand-dot"></div>
                <div class="brand-name">S<span>_</span>Topic</div>
            </div>
            <div class="left-title">Sistema de Gestión del Tópico Institucional</div>
            <div class="left-sub">IEST Público "Túpac Amaru" — Cusco<br>Unidad de Bienestar y Empleabilidad</div>
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">🩺</div>
                    <div class="feature-text">
                        <p>Registro de atenciones</p>
                        <span>Historial clínico digitalizado</span>
                    </div>
                </div>
                <div class="feature">
                    <div class="feature-icon">🔍</div>
                    <div class="feature-text">
                        <p>Búsqueda instantánea</p>
                        <span>Por DNI con datos médicos</span>
                    </div>
                </div>
                <div class="feature">
                    <div class="feature-icon">⚠️</div>
                    <div class="feature-text">
                        <p>Alertas recurrentes</p>
                        <span>Detección automática de casos</span>
                    </div>
                </div>
                <div class="feature">
                    <div class="feature-icon">📊</div>
                    <div class="feature-text">
                        <p>Reportes estadísticos</p>
                        <span>Análisis de atenciones por período</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel derecho --}}
    <div class="login-right">
        <div class="login-header">
            <h1>Bienvenido 👋</h1>
            <p>Ingresa tus credenciales para acceder al sistema</p>
        </div>

        @if($errors->any())
        <div style="background:#fde8ea;border:1px solid #fca5a5;border-radius:9px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#be123c;display:flex;align-items:center;gap:8px;">
            ❌ {{ $errors->first() }}
        </div>
        @endif

        @if(session('status'))
        <div style="background:#d4f0de;border:1px solid #86efac;border-radius:9px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#15803d;">
            ✅ {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf
            <div class="form-group">
                <label>Correo electrónico</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email')?'is-invalid':'' }}" placeholder="correo@istta.edu.pe" autofocus autocomplete="email">
                </div>
                @error('email')<div class="invalid-msg">⚠ {{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <div class="input-wrap">
                    <svg class="input-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <input type="password" name="password" id="pw-field" class="form-control {{ $errors->has('password')?'is-invalid':'' }}" placeholder="••••••••" autocomplete="current-password">
                    <span class="toggle-pw" onclick="togglePw()" title="Mostrar/ocultar">
                        <svg id="eye-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </span>
                </div>
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember"> Recordarme
                </label>
                @if(Route::has('password.request'))
                    
                <div style="text-align:center; margin-top:16px; margin-bottom:16px;">
                    <p style="font-size:13px; color:var(--muted);">
                        ¿Olvidaste tu contraseña?
                        <a href="{{ route('password.request') }}" style="color:var(--primary); text-decoration:none; font-weight:600;">
                            Recuperarla aquí
                        </a>
                    </p>
                </div>
                @endif
            </div>

            <button type="submit" class="btn-login" id="btn-login">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Iniciar sesión
            </button>
        </form>

        <div class="login-footer">
            S_Topic v2.0 · ISTTA "Túpac Amaru" · Cusco, Perú
        </div>
    </div>
</div>

<script>
function togglePw() {
    const f = document.getElementById('pw-field');
    f.type = f.type === 'password' ? 'text' : 'password';
}
document.getElementById('login-form').addEventListener('submit', function() {
    const btn = document.getElementById('btn-login');
    btn.disabled = true;
    btn.innerHTML = '<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="animation:spin 1s linear infinite"><path d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 11-8 8"/></svg> Verificando...';
    setTimeout(() => { btn.disabled = false; btn.innerHTML = 'Iniciar sesión'; }, 5000);
});
</script>
<style>@keyframes spin{to{transform:rotate(360deg);}}</style>
</body>
</html>
