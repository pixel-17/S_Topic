@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
 
@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#e6f4f4;">👥</div>
        <div>
            <div class="value">{{ $totalEstudiantes }}</div>
            <div class="label">Estudiantes registrados</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;">📋</div>
        <div>
            <div class="value">{{ $totalAtenciones }}</div>
            <div class="label">Atenciones totales</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;">🏥</div>
        <div>
            <div class="value">{{ $atencionesHoy }}</div>
            <div class="label">Atenciones hoy</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff3e0;">⚠️</div>
        <div>
            <div class="value" style="color:#e65100;">{{ $casosRecurrentes }}</div>
            <div class="label">Casos recurrentes</div>
        </div>
    </div>
</div>
 
<div class="card">
    <div class="page-header" style="margin-bottom:16px;">
        <div>
            <h1 style="font-size:16px;">Últimas atenciones</h1>
            <p>Las 5 atenciones más recientes registradas</p>
        </div>
        <a href="{{ route('atenciones.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
            Nueva atención
        </a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Estudiante</th>
                    <th>Motivo</th>
                    <th>Atendido por</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimasAtenciones as $at)
                <tr>
                    <td style="font-family:'DM Mono',monospace;font-size:13px;color:var(--muted);">
                        {{ $at->fecha->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        <div style="font-weight:500;">{{ $at->estudiante->nombre_completo }}</div>
                        <div style="font-size:12px;color:var(--muted);">{{ $at->estudiante->dni }}</div>
                    </td>
                    <td>{{ $at->motivo->nombre }}</td>
                    <td>{{ $at->enfermera->nombre_completo }}</td>
                    <td>
                        @if($at->es_recurrente)
                            <span class="badge badge-warning">⚠ Recurrente</span>
                        @else
                            <span class="badge badge-success">Normal</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('atenciones.show', $at) }}" class="btn btn-outline btn-sm">Ver</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:32px;">No hay atenciones registradas aún.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection