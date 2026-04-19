<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte — {{ $estudiante->nombre_completo }}</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono&display=swap" rel="stylesheet">
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; color: #1a1a2e; font-size: 13px; padding: 32px; }
    .header { border-bottom: 3px solid #1a6b6b; padding-bottom: 16px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; }
    .logo h1 { font-size: 20px; font-weight: 700; color: #1a6b6b; }
    .logo p { font-size: 11px; color: #6b7280; margin-top: 2px; }
    .fecha { font-size: 12px; color: #6b7280; text-align: right; }
    .titulo { font-size: 16px; font-weight: 700; text-align: center; margin-bottom: 20px; text-transform: uppercase; letter-spacing: .5px; }
    .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; }
    .section { border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px; }
    .section-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #6b7280; margin-bottom: 10px; }
    .row { display: flex; gap: 8px; margin-bottom: 6px; font-size: 12px; }
    .row label { color: #6b7280; min-width: 100px; }
    .badge-sangre { background: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 10px; font-weight: 700; font-size: 12px; }
    .alergias { background: #fff3e0; border: 1px solid #ffcc80; border-radius: 6px; padding: 8px; color: #e65100; font-size: 12px; margin-top: 6px; }
    table { width: 100%; border-collapse: collapse; font-size: 12px; }
    th { background: #f3f4f6; padding: 8px 10px; text-align: left; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #6b7280; }
    td { padding: 8px 10px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
    .recurrente { background: #fef3c7; color: #92400e; padding: 2px 7px; border-radius: 10px; font-size: 10px; font-weight: 600; }
    .normal { background: #d1fae5; color: #065f46; padding: 2px 7px; border-radius: 10px; font-size: 10px; font-weight: 600; }
    .firma { margin-top: 40px; display: flex; justify-content: flex-end; }
    .firma-box { text-align: center; }
    .firma-line { width: 200px; border-top: 1px solid #1a1a2e; padding-top: 6px; font-size: 12px; }
    @media print { body { padding: 0; } button { display: none; } }
</style>
</head>
<body>
<div class="header">
    <div class="logo">
        <h1>S_Topic</h1>
        <p>IEST Público "Túpac Amaru" — Cusco</p>
        <p>Unidad de Bienestar y Empleabilidad — Tópico</p>
    </div>
    <div class="fecha">
        <p>Fecha de emisión:</p>
        <p><strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
        <p style="margin-top:8px;">Emitido por: {{ auth()->user()->nombre_completo }}</p>
    </div>
</div>
 
<div class="titulo">Reporte de Historial Clínico</div>
 
<div class="grid2">
    <div class="section">
        <div class="section-title">Datos del estudiante</div>
        <div class="row"><label>Nombre:</label><strong>{{ $estudiante->nombre_completo }}</strong></div>
        <div class="row"><label>DNI:</label><span style="font-family:'DM Mono',monospace;">{{ $estudiante->dni }}</span></div>
        <div class="row"><label>Género:</label>{{ $estudiante->genero === 'M' ? 'Masculino' : 'Femenino' }}</div>
        <div class="row"><label>Fecha nac.:</label>{{ $estudiante->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</div>
        <div class="row"><label>Carrera:</label>{{ $estudiante->carrera->nombre ?? '—' }}</div>
        <div class="row"><label>Semestre:</label>{{ $estudiante->semestre ?? '—' }}</div>
        <div class="row"><label>Teléfono:</label>{{ $estudiante->telefono ?? '—' }}</div>
    </div>
 
    <div class="section">
        <div class="section-title">Ficha médica</div>
        @if($estudiante->fichaMedica)
        <div class="row"><label>Tipo sangre:</label>
            @if($estudiante->fichaMedica->tipo_sangre)
                <span class="badge-sangre">{{ $estudiante->fichaMedica->tipo_sangre }}</span>
            @else —@endif
        </div>
        @if($estudiante->fichaMedica->alergias)
        <div class="alergias">⚠️ <strong>Alergias:</strong> {{ $estudiante->fichaMedica->alergias }}</div>
        @endif
        @if($estudiante->fichaMedica->enfermedades_previas)
        <div class="row" style="margin-top:6px;"><label>Enf. previas:</label>{{ $estudiante->fichaMedica->enfermedades_previas }}</div>
        @endif
        @if($estudiante->fichaMedica->medicamentos_actuales)
        <div class="row"><label>Medicamentos:</label>{{ $estudiante->fichaMedica->medicamentos_actuales }}</div>
        @endif
        @if($estudiante->fichaMedica->contacto_emergencia)
        <div class="row"><label>Emergencia:</label>{{ $estudiante->fichaMedica->contacto_emergencia }} — {{ $estudiante->fichaMedica->telefono_emergencia }}</div>
        @endif
        @else <p style="color:#6b7280;">Sin ficha médica.</p>
        @endif
    </div>
</div>
 
<div class="section" style="margin-bottom:20px;">
    <div class="section-title">Historial de atenciones ({{ $atenciones->count() }} registros)</div>
    <table>
        <thead>
            <tr><th>#</th><th>Fecha</th><th>Motivo</th><th>Diagnóstico</th><th>Tratamiento</th><th>Enfermera</th><th>Estado</th></tr>
        </thead>
        <tbody>
            @forelse($atenciones as $i => $at)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-family:'DM Mono',monospace;white-space:nowrap;">{{ $at->fecha->format('d/m/Y H:i') }}</td>
                <td><strong>{{ $at->motivo->nombre }}</strong></td>
                <td>{{ $at->diagnostico ?? '—' }}</td>
                <td>{{ $at->tratamiento ?? '—' }}</td>
                <td>{{ $at->enfermera->name }}</td>
                <td>
                    @if($at->es_recurrente)<span class="recurrente">⚠ Recurrente</span>
                    @else<span class="normal">Normal</span>@endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#6b7280;padding:20px;">Sin atenciones.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
 
<div class="firma">
    <div class="firma-box">
        <div class="firma-line">Personal del Tópico — ISTTA</div>
    </div>
</div>
 
<script>window.onload = () => window.print();</script>
</body>
</html>