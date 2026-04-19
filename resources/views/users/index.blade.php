@extends('layouts.app')
@section('title', 'Usuarios')
@section('page-title', 'Gestión de Usuarios')
 
@section('content')
<div class="page-header">
    <div><h1>Usuarios del sistema</h1><p>Administración de cuentas de acceso</p></div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">+ Nuevo usuario</a>
</div>
 
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th>Registrado</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>
                        <div style="font-weight:500;">{{ $u->nombre_completo }}</div>
                    </td>
                    <td style="font-size:13px;color:var(--muted);">{{ $u->email }}</td>
                    <td>
                        <span class="badge {{ $u->isAdmin() ? 'badge-warning' : 'badge-primary' }}">
                            {{ $u->isAdmin() ? 'Administrador' : 'Enfermera' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $u->activo ? 'badge-success' : 'badge-danger' }}">
                            {{ $u->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td style="font-size:13px;color:var(--muted);">{{ $u->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('users.edit', $u) }}" class="btn btn-outline btn-sm">Editar</a>
                            @if($u->id !== auth()->id())
                            <form method="POST" action="{{ route('users.toggle', $u) }}" style="display:inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $u->activo ? 'btn-danger' : 'btn-accent' }}">
                                    {{ $u->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:40px;">No hay usuarios registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $users->links() }}</div>
</div>
@endsection