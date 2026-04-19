@extends('layouts.app')
@section('title', 'Reportes')
@section('page-title', 'Reportes Estadísticos')
 
@section('content')
<div class="page-header">
    <div><h1>Reportes del Tópico</h1><p>Estadísticas de atenciones médicas</p></div>
</div>
 
<div class="stats-grid" style="grid-template-columns:repeat(2,1fr);margin-bottom:20px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;">📅</div>
        <div>
            <div class="value">{{ $atencionsMes }}</div>
            <div class="label">Atenciones este mes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff3e0;">⚠️</div>
        <div>
            <div class="value" style="color:#e65100;">{{ $casosRecurrentes->count() }}</div>
            <div class="label">Casos recurrentes recientes</div>
        </div>
    </div>
</div>
 
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
    <div class="card">
        <p class="section-title">📊 Motivos más frecuentes</p>
        <div style="display:flex;flex-direction:column;gap:10px;">
            @forelse($motivosFrecuentes as $m)
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="flex:1;">
                    <div style="font-size:13px;font-weight:500;margin-bottom:4px;">{{ $m->nombre }}</div>
                    <div style="background:#e5e7eb;border-radius:4px;height:6px;overflow:hidden;">
                        <div style="background:var(--accent);height:100%;width:{{ $motivosFrecuentes->first()->atenciones_count > 0 ? ($m->atenciones_count / $motivosFrecuentes->first()->atenciones_count * 100) : 0 }}%;border-radius:4px;transition:width .3s;"></div>
                    </div>
                </div>
                <div style="font-size:13px;font-weight:700;min-width:30px;text-align:right;">{{ $m->atenciones_count }}</div>
            </div>
            @empty
            <p style="color:var(--muted);font-size:13px;">Sin datos disponibles.</p>
            @endforelse
        </div>
    </div>
 
    <div class="card">
        <p class="section-title">⚠️ Casos recurrentes recientes</p>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Estudiante</th><th>Motivo</th><th>Fecha</th></tr></thead>
                <tbody>
                    @forelse($casosRecurrentes as $at)
                    <tr>
                        <td>
                            <div style="font-size:13px;font-weight:500;">{{ $at->estudiante->nombre_completo }}</div>
                            <div style="font-size:11px;color:var(--muted);">{{ $at->estudiante->dni }}</div>
                        </td>
                        <td style="font-size:13px;">{{ $at->motivo->nombre }}</td>
                        <td style="font-size:12px;color:var(--muted);font-family:'DM Mono',monospace;">{{ $at->fecha->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;color:var(--muted);padding:20px;">Sin casos recurrentes.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
 
<div class="card">
    <p class="section-title">📈 Atenciones por mes (últimos 6 meses)</p>
    <div style="display:flex;align-items:flex-end;gap:12px;height:160px;padding:10px 0;">
        @php $maxVal = $atencionsPorMes->max('total') ?: 1; @endphp
        @forelse($atencionsPorMes as $mes)
        <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;">
            <div style="font-size:12px;font-weight:600;color:var(--text);">{{ $mes->total }}</div>
            <div style="width:100%;background:var(--accent);border-radius:4px 4px 0 0;height:{{ ($mes->total / $maxVal) * 120 }}px;min-height:4px;"></div>
            <div style="font-size:11px;color:var(--muted);text-align:center;">
                {{ \Carbon\Carbon::create($mes->anio, $mes->mes)->locale('es')->monthName }}<br>{{ $mes->anio }}
            </div>
        </div>
        @empty
        <p style="color:var(--muted);font-size:13px;">Sin datos disponibles.</p>
        @endforelse
    </div>
</div>
@endsection