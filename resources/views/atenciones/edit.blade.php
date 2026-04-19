@extends('layouts.app')
@section('title', 'Editar Atención')
@section('page-title', 'Editar Atención')
 
@section('content')
<div class="page-header">
    <div><h1>Editar Atención #{{ $atencion->id }}</h1><p>{{ $atencion->fecha->format('d/m/Y H:i') }}</p></div>
    <a href="{{ route('atenciones.show', $atencion) }}" class="btn btn-outline">← Volver</a>
</div>
 
<form method="POST" action="{{ route('atenciones.update', $atencion) }}">
@csrf @method('PUT')
<div class="card">
    <div class="form-grid">
        <div class="form-group col-span-2">
            <label>Estudiante</label>
            <input type="text" class="form-control" value="{{ $atencion->estudiante->nombre_completo }} — {{ $atencion->estudiante->dni }}" disabled>
            <input type="hidden" name="estudiante_id" value="{{ $atencion->estudiante_id }}">
        </div>
        <div class="form-group col-span-2">
            <label>Motivo de consulta <span style="color:var(--danger)">*</span></label>
            <select name="motivo_id" class="form-control" required>
                @foreach($categorias as $cat)
                    <optgroup label="{{ $cat->nombre }}">
                        @foreach($cat->motivos as $m)
                            <option value="{{ $m->id }}" {{ $atencion->motivo_id == $m->id ? 'selected' : '' }}>{{ $m->nombre }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="form-group col-span-2">
            <label>Fecha y hora</label>
            <input type="datetime-local" name="fecha" value="{{ $atencion->fecha->format('Y-m-d\TH:i') }}" class="form-control" required>
        </div>
        <div class="form-group col-span-2">
            <label>Diagnóstico</label>
            <textarea name="diagnostico" class="form-control" rows="3">{{ $atencion->diagnostico }}</textarea>
        </div>
        <div class="form-group col-span-2">
            <label>Tratamiento</label>
            <textarea name="tratamiento" class="form-control" rows="3">{{ $atencion->tratamiento }}</textarea>
        </div>
        <div class="form-group col-span-2">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="2">{{ $atencion->observaciones }}</textarea>
        </div>
        <div class="form-group col-span-2" style="display:flex;align-items:center;gap:10px;">
            <input type="checkbox" name="derivado" id="derivado" value="1" {{ $atencion->derivado ? 'checked' : '' }} style="width:16px;height:16px;accent-color:var(--primary);">
            <label for="derivado" style="font-size:14px;cursor:pointer;">Caso derivado a especialista</label>
        </div>
    </div>
    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:8px;">
        <a href="{{ route('atenciones.show', $atencion) }}" class="btn btn-outline">Cancelar</a>
        <button type="submit" class="btn btn-primary">💾 Guardar cambios</button>
    </div>
</div>
</form>
@endsection