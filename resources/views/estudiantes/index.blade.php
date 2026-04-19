@extends('layouts.app')
@section('title', 'Estudiantes')
@section('page-title', 'Estudiantes')
 
@section('content')
<div class="page-header">
    <div>
        <h1>Estudiantes</h1>
        <p>Registro y gestión de estudiantes del ISTTA</p>
    </div>
    <a href="{{ route('estudiantes.create') }}" class="btn btn-primary">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        Nuevo estudiante
    </a>
</div>
 
<div class="card card-sm" style="margin-bottom:16px;">
    <form method="GET" style="display:flex;gap:12px;align-items:flex-end;">
        <div style="flex:1;">
            <label style="font-size:13px;font-weight:500;display:block;margin-bottom:5px;">Buscar por DNI</label>
            <input type="text" name="dni" value="{{ request('dni') }}" class="form-control" placeholder="Ej: 12345678" maxlength="8">
        </div>
        <div style="flex:2;">
            <label style="font-size:13px;font-weight:500;display:block;margin-bottom:5px;">Buscar por nombre</label>
            <input type="text" name="nombre" value="{{ request('nombre') }}" class="form-control" placeholder="Nombres o apellidos...">
        </div>
        <button type="submit" class="btn btn-accent">🔍 Buscar</button>
        <a href="{{ route('estudiantes.index') }}" class="btn btn-outline">Limpiar</a>
    </form>
</div>
 
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombre completo</th>
                    <th>Carrera</th>
                    <th>Semestre</th>
                    <th>Tipo sangre</th>
                    <th>Atenciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($estudiantes as $est)
                <tr>
                    <td style="font-family:'DM Mono',monospace;font-size:13px;font-weight:500;">{{ $est->dni }}</td>
                    <td>
                        <div style="font-weight:500;">{{ $est->nombre_completo }}</div>
                        <div style="font-size:12px;color:var(--muted);">{{ $est->genero === 'M' ? 'Masculino' : 'Femenino' }}</div>
                    </td>
                    <td style="font-size:13px;">{{ $est->carrera->nombre ?? '—' }}</td>
                    <td style="font-size:13px;">{{ $est->semestre ?? '—' }}</td>
                    <td>
                        @if($est->fichaMedica?->tipo_sangre)
                            <span class="badge badge-danger">{{ $est->fichaMedica->tipo_sangre }}</span>
                        @else
                            <span style="color:var(--muted);font-size:13px;">—</span>
                        @endif
                    </td>
                    <td style="font-size:13px;">{{ $est->atenciones_count ?? $est->atenciones->count() }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('estudiantes.show', $est) }}" class="btn btn-outline btn-sm">Ver</a>
                            <a href="{{ route('atenciones.historial', $est) }}" class="btn btn-accent btn-sm">Historial</a>
                            <a href="{{ route('estudiantes.edit', $est) }}" class="btn btn-outline btn-sm">Editar</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:40px;">No se encontraron estudiantes.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;">{{ $estudiantes->withQueryString()->links() }}</div>
</div>
@endsection