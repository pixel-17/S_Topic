<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">

        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 border">

            <!-- Logo -->
            <div class="flex justify-center mb-4">
                <x-authentication-card-logo />
            </div>

            <!-- Título -->
            <h2 class="text-xl font-semibold text-gray-800 text-center mb-2">
                Acceso restringido
            </h2>

            <p class="text-sm text-gray-500 text-center mb-6">
                Recuperación de contraseña deshabilitada
            </p>

            <!-- Línea -->
            <div class="border-t mb-6"></div>

            <!-- Mensaje -->
            <div class="text-sm text-gray-600 text-center mb-6 leading-relaxed">
                Por políticas de seguridad del sistema, esta opción no está disponible.
            </div>

            <!-- Alerta -->
            <div class="flex items-start gap-3 p-4 rounded-lg bg-yellow-50 border border-yellow-300 text-yellow-800 mb-6">
                <span class="text-lg">⚠️</span>
                <span class="text-sm">
                    Comuníquese con el administrador para restablecer su acceso.
                </span>
            </div>

            <!-- Contacto -->
            <div class="text-center text-sm text-gray-500 mb-6">
                Soporte: <span class="text-blue-600 font-medium">admin@istta.edu.pe</span>
            </div>

            <!-- Botón -->
            <div class="text-center">
                <a href="{{ route('login') }}"
                   class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg shadow">
                    Volver al inicio
                </a>
            </div>

        </div>

    </div>
</x-guest-layout>