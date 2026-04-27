<div style="max-width:500px; margin:40px auto; font-family:Arial, sans-serif;">
    
    <div style="background:#fff; padding:28px; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
        
        <h2 style="margin-bottom:6px; color:#111827;">🔐 Restablecer Contraseña</h2>
        <p style="color:#6b7280; margin-bottom:20px;">
            Ingresa una nueva contraseña segura para tu cuenta
        </p>

        {{-- ERRORES --}}
        @if($errors->any())
            <div style="background:#fee2e2; border:1px solid #fca5a5; padding:12px; border-radius:6px; color:#991b1b; margin-bottom:16px;">
                @foreach($errors->all() as $error)
                    <div>• {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            {{-- PASSWORD --}}
            <div style="margin-bottom:16px;">
                <label style="display:block; margin-bottom:6px; font-weight:500;">
                    Nueva Contraseña
                </label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"
                    placeholder="Mínimo 8 caracteres"
                >
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:6px; font-weight:500;">
                    Confirmar Contraseña
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    required
                    style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;"
                    placeholder="Repite la contraseña"
                >
            </div>

            {{-- BOTÓN --}}
            <button type="submit"
                style="width:100%; background:#2563eb; color:white; padding:12px; border:none; border-radius:6px; font-weight:600; cursor:pointer;">
                ✓ Restablecer Contraseña
            </button>
        </form>

        {{-- LINK --}}
        <div style="text-align:center; margin-top:18px;">
            <a href="{{ route('login') }}" style="color:#2563eb; text-decoration:none;">
                ← Volver al Login
            </a>
        </div>

    </div>

</div>