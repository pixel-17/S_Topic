@extends('layouts.app')
@section('title', 'Nueva Atención')
@section('page-title', 'Registrar Atención')
 
@section('content')
<div class="page-header">
    <div><h1>Nueva Atención Médica</h1><p>Registra una nueva atención en el tópico</p></div>
    <a href="{{ route('atenciones.index') }}" class="btn btn-outline">← Volver</a>
</div>
 
<form method="POST" action="{{ route('atenciones.store') }}">
@csrf
<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">
    <div>
        {{-- Búsqueda de estudiante --}}
        <div class="card" style="margin-bottom:16px;">
            <p class="section-title">👤 Buscar estudiante</p>
            <div style="display:flex;gap:10px;margin-bottom:16px;">
                <input type="text" id="buscar-dni" class="form-control" placeholder="Ingresa el DNI del estudiante..." maxlength="8">
                <button type="button" onclick="buscarEstudiante()" class="btn btn-accent">🔍 Buscar</button>
            </div>
            <div id="resultado-estudiante" style="display:none;">
                <div style="background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:16px;">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;">
                        <div>
                            <div style="font-weight:600;font-size:16px;" id="est-nombre"></div>
                            <div style="font-size:13px;color:var(--muted);" id="est-info"></div>
                        </div>
                        <div style="text-align:right;">
                            <div id="est-sangre"></div>
                        </div>
                    </div>
                    <div id="est-alergias" style="margin-top:10px;display:none;"></div>
                </div>
            </div>
            <div id="error-estudiante" style="display:none;" class="alert alert-danger" style="margin:0;"></div>
            <input type="hidden" name="estudiante_id" id="estudiante-id">
        </div>
 
        {{-- Datos de la atención --}}
        <div class="card">
            <p class="section-title">📋 Datos de la atención</p>
            <div class="form-grid">
                <div class="form-group col-span-2">
                    <label>Motivo de consulta <span style="color:var(--danger)">*</span></label>
                    <select name="motivo_id" class="form-control {{ $errors->has('motivo_id') ? 'is-invalid' : '' }}" required>
                        <option value="">Seleccionar motivo...</option>
                        @foreach($categorias as $cat)
                            <optgroup label="{{ $cat->nombre }}">
                                @foreach($cat->motivos as $m)
                                    <option value="{{ $m->id }}" {{ old('motivo_id') == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('motivo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-span-2">
                    <label>Fecha y hora <span style="color:var(--danger)">*</span></label>
                    <input type="datetime-local" name="fecha" value="{{ old('fecha', now()->format('Y-m-d\TH:i')) }}" class="form-control" required>
                </div>
                <div class="form-group col-span-2">
                    <label>Diagnóstico</label>
                    <textarea name="diagnostico" class="form-control" rows="3" placeholder="Describe el diagnóstico...">{{ old('diagnostico') }}</textarea>
                </div>
                <div class="form-group col-span-2">
                    <label>Tratamiento</label>
                    <textarea name="tratamiento" class="form-control" rows="3" placeholder="Tratamiento administrado...">{{ old('tratamiento') }}</textarea>
                </div>
                <div class="form-group col-span-2">
                    <label>Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="2" placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>
                </div>
            </div>
        </div>
    </div>
 
    <div>
        <div class="card">
            <p class="section-title">Opciones adicionales</p>
            <div style="display:flex;align-items:center;gap:10px;padding:10px 0;border-bottom:1px solid var(--border);">
                <input type="checkbox" name="derivado" id="derivado" value="1" {{ old('derivado') ? 'checked' : '' }} style="width:16px;height:16px;accent-color:var(--primary);">
                <label for="derivado" style="font-size:14px;cursor:pointer;">Caso derivado a especialista</label>
            </div>
            <div style="padding-top:16px;">
                <div style="background:var(--primary-lt);border-radius:8px;padding:12px;font-size:13px;color:var(--primary);">
                    ℹ️ El sistema detectará automáticamente si es un <strong>caso recurrente</strong> al guardar la atención.
                </div>
            </div>
        </div>
        <div style="margin-top:14px;">
            <button type="submit" class="btn btn-primary" style="width:100%;padding:12px;">💾 Registrar atención</button>
        </div>
    </div>
</div>
</form>
 
<script>
async function buscarEstudiante() {
    const dni = document.getElementById('buscar-dni').value.trim();
    if (dni.length !== 8) { alert('El DNI debe tener 8 dígitos.'); return; }
 
    try {
        const res = await fetch(`/estudiantes/buscar/dni?dni=${dni}`);
        const data = await res.json();
 
        if (!res.ok) {
            document.getElementById('resultado-estudiante').style.display = 'none';
            document.getElementById('error-estudiante').style.display = 'block';
            document.getElementById('error-estudiante').textContent = '❌ Estudiante no encontrado. Verifique el DNI.';
            document.getElementById('estudiante-id').value = '';
            return;
        }
 
        document.getElementById('error-estudiante').style.display = 'none';
        document.getElementById('resultado-estudiante').style.display = 'block';
        document.getElementById('estudiante-id').value = data.id;
        document.getElementById('est-nombre').textContent = data.nombres + ' ' + data.apellidos;
        document.getElementById('est-info').textContent = 'DNI: ' + data.dni + (data.carrera ? ' · ' + data.carrera.nombre : '');
 
        if (data.ficha_medica?.tipo_sangre) {
            document.getElementById('est-sangre').innerHTML = `<span class="badge badge-danger" style="font-size:14px;padding:4px 12px;">${data.ficha_medica.tipo_sangre}</span>`;
        }
 
        if (data.ficha_medica?.alergias) {
            const aDiv = document.getElementById('est-alergias');
            aDiv.style.display = 'block';
            aDiv.innerHTML = `<div class="alert alert-warning" style="margin:0;">⚠️ <strong>Alergias:</strong> ${data.ficha_medica.alergias}</div>`;
        }
    } catch(e) {
        console.error(e);
    }
}
 
document.getElementById('buscar-dni').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') { e.preventDefault(); buscarEstudiante(); }
});
</script>
@endsection