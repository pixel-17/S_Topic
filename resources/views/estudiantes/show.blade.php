@extends('layouts.app')
@section('title', 'Ficha del Estudiante')
@section('page-title', 'Ficha del Estudiante')
 
@section('content')
<div class="page-header">
    <div>
        <h1>{{ $estudiante->nombre_completo }}</h1>
        <p>DNI: {{ $estudiante->dni }} · {{ $estudiante->carrera->nombre ?? 'Sin carrera' }}</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="{{ route('atenciones.reporte', $estudiante) }}" class="btn btn-outline no-print" target="_blank">🖨 Imprimir reporte</a>
        <a href="{{ route('atenciones.create') }}?estudiante_id={{ $estudiante->id }}" class="btn btn-accent">+ Nueva atención</a>
        <a href="{{ route('estudiantes.edit', $estudiante) }}" class="btn btn-outline">Editar</a>
        <a href="{{ route('estudiantes.index') }}" class="btn btn-outline">← Volver</a>
    </div>
</div>
 
<div style="display:grid;grid-template-columns:320px 1fr;gap:20px;align-items:start;">
    <div>
        <div class="card" style="margin-bottom:14px;">
            <p class="section-title">Datos personales</p>
            <div style="display:flex;flex-direction:column;gap:10px;font-size:14px;">
                <div><span style="color:var(--muted);">Género:</span> {{ $estudiante->genero === 'M' ? 'Masculino' : ($estudiante->genero === 'F' ? 'Femenino' : '—') }}</div>
                <div><span style="color:var(--muted);">Fecha nac.:</span> {{ $estudiante->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</div>
                <div><span style="color:var(--muted);">Edad:</span> {{ $estudiante->edad ? $estudiante->edad . ' años' : '—' }}</div>
                <div><span style="color:var(--muted);">Teléfono:</span> {{ $estudiante->telefono ?? '—' }}</div>
                <div><span style="color:var(--muted);">Semestre:</span> {{ $estudiante->semestre ?? '—' }}</div>
            </div>
        </div>
 
        <div class="card">
            <p class="section-title">🩺 Ficha médica</p>
            @if($estudiante->fichaMedica)
            <div style="display:flex;flex-direction:column;gap:12px;font-size:14px;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <span style="color:var(--muted);">Tipo de sangre:</span>
                    @if($estudiante->fichaMedica->tipo_sangre)
                        <span class="badge badge-danger" style="font-size:14px;padding:4px 12px;">{{ $estudiante->fichaMedica->tipo_sangre }}</span>
                    @else <span>—</span> @endif
                </div>
                @if($estudiante->fichaMedica->alergias)
                <div>
                    <div style="color:var(--muted);margin-bottom:4px;">⚠️ Alergias:</div>
                    <div style="background:#fff3e0;border:1px solid #ffcc80;border-radius:6px;padding:8px 10px;color:#e65100;font-size:13px;">{{ $estudiante->fichaMedica->alergias }}</div>
                </div>
                @endif
                @if($estudiante->fichaMedica->enfermedades_previas)
                <div><span style="color:var(--muted);">Enf. previas:</span><br><span style="font-size:13px;">{{ $estudiante->fichaMedica->enfermedades_previas }}</span></div>
                @endif
                @if($estudiante->fichaMedica->medicamentos_actuales)
                <div><span style="color:var(--muted);">Medicamentos:</span><br><span style="font-size:13px;">{{ $estudiante->fichaMedica->medicamentos_actuales }}</span></div>
                @endif
                @if($estudiante->fichaMedica->contacto_emergencia)
                <div><span style="color:var(--muted);">Emergencia:</span> {{ $estudiante->fichaMedica->contacto_emergencia }} — {{ $estudiante->fichaMedica->telefono_emergencia }}</div>
                @endif
            </div>
            @else
            <p style="color:var(--muted);font-size:13px;">Sin ficha médica registrada.</p>
            @endif
        </div>
    </div>
 
    <div class="card">
        <div class="page-header" style="margin-bottom:16px;">
            <p class="section-title" style="margin:0;">Historial de atenciones ({{ $atenciones->total() }})</p>
            <a href="{{ route('atenciones.historial', $estudiante) }}" class="btn btn-outline btn-sm">Ver historial completo</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Motivo</th>
                        <th>Diagnóstico</th>
                        <th>Atendido por</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($atenciones as $at)
                    <tr>
                        <td style="font-family:'DM Mono',monospace;font-size:12px;color:var(--muted);">{{ $at->fecha->format('d/m/Y H:i') }}</td>
                        <td style="font-size:13px;">{{ $at->motivo->nombre }}</td>
                        <td style="font-size:13px;max-width:200px;">{{ Str::limit($at->diagnostico, 60) ?? '—' }}</td>
                        <td style="font-size:13px;">{{ $at->enfermera->name }}</td>
                        <td>
                            @if($at->es_recurrente)
                                <span class="badge badge-warning">⚠ Recurrente</span>
                            @else
                                <span class="badge badge-success">Normal</span>
                            @endif
                        </td>
                        <td><a href="{{ route('atenciones.show', $at) }}" class="btn btn-outline btn-sm">Ver</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--muted);padding:32px;">Sin atenciones registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:14px;">{{ $atenciones->links() }}</div>
    </div>
</div>
@endsection