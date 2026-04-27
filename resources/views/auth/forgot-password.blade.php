@section('title', 'Recuperar Contraseña')

<div style="max-width:500px; margin:60px auto; font-family:Arial, sans-serif;">
    
    <div style="background:#ffffff; padding:28px; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

        <h2 style="margin-bottom:6px; color:#111827;">🔐 Recuperar Contraseña</h2>

        <p style="color:#6b7280; margin-bottom:20px;">
            Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
        </p>

        {{-- MENSAJE DE ÉXITO --}}
        @if(session('success'))
            <div style="background:#dcfce7; border:1px solid #86efac; padding:12px; border-radius:6px; color:#166534; margin-bottom:16px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERRORES --}}
        @if($errors->any())
            <div style="background:#fee2e2; border:1px solid #fca5a5; padding:12px; border-radius:6px; color:#991b1b; margin-bottom:16px;">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.send') }}">
            @csrf
            
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:6px; font-weight:500;">
                    Correo Electrónico
                </label>

                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                    style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"
                    placeholder="ejemplo@correo.com"
                >

                <small style="color:#6b7280;">
                    Asegúrate de ingresar el correo registrado en el sistema
                </small>
            </div>

            <button type="submit"
                style="width:100%; background:#2563eb; color:white; padding:12px; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                📧 Enviar enlace de recuperación
            </button>
        </form>

        <div style="text-align:center; margin-top:18px;">
            <a href="{{ route('login') }}" style="color:#2563eb; text-decoration:none;">
                ← Volver al Login
            </a>
        </div>

    </div>
</div>