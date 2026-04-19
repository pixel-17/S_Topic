@extends('layouts.app')
@section('title', 'Nuevo Estudiante')
@section('page-title', 'Nuevo Estudiante')
 
@section('content')
<div class="page-header">
    <div>
        <h1>Registrar Estudiante</h1>
        <p>Completa los datos personales y la ficha médica</p>
    </div>
    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline">← Volver</a>
</div>
 
<form method="POST" action="{{ route('estudiantes.store') }}">
@csrf
<div style="display:grid;grid-template-columns:1fr 380px;gap:20px;align-items:start;">
 
    <div>
        <div class="card" style="margin-bottom:16px;">
            <p class="section-title">Datos personales</p>
            <div class="form-grid">
                <div class="form-group">
                    <label>DNI <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="dni" value="{{ old('dni') }}" class="form-control {{ $errors->has('dni') ? 'is-invalid' : '' }}" maxlength="8" placeholder="8 dígitos">
                    @error('dni')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Género</label>
                    <select name="genero" class="form-control">
                        <option value="">Seleccionar...</option>
                        <option value="M" {{ old('genero') === 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('genero') === 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nombres <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="nombres" value="{{ old('nombres') }}" class="form-control {{ $errors->has('nombres') ? 'is-invalid' : '' }}">
                    @error('nombres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Apellidos <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="apellidos" value="{{ old('apellidos') }}" class="form-control {{ $errors->has('apellidos') ? 'is-invalid' : '' }}">
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control" placeholder="9XXXXXXXX">
                </div>
                <div class="form-group">
                    <label>Carrera</label>
                    <select name="carrera_id" class="form-control">
                        <option value="">Seleccionar...</option>
                        @foreach($carreras as $c)
                            <option value="{{ $c->id }}" {{ old('carrera_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Semestre</label>
                    <input type="text" name="semestre" value="{{ old('semestre') }}" class="form-control" placeholder="Ej: III Semestre">
                </div>
            </div>
        </div>
    </div>
 
    <div>
        <div class="card">
            <p class="section-title">🩺 Ficha médica</p>
            <div class="form-group">
                <label>Tipo de sangre</label>
                <select name="tipo_sangre" class="form-control">
                    <option value="">No especificado</option>
                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $ts)
                        <option value="{{ $ts }}" {{ old('tipo_sangre') === $ts ? 'selected' : '' }}>{{ $ts }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Alergias conocidas</label>
                <textarea name="alergias" class="form-control" rows="2" placeholder="Ej: Penicilina, polvo...">{{ old('alergias') }}</textarea>
            </div>
            <div class="form-group">
                <label>Enfermedades previas</label>
                <textarea name="enfermedades_previas" class="form-control" rows="2" placeholder="Ej: Asma, diabetes...">{{ old('enfermedades_previas') }}</textarea>
            </div>
            <div class="form-group">
                <label>Medicamentos actuales</label>
                <textarea name="medicamentos_actuales" class="form-control" rows="2" placeholder="Medicamentos que toma actualmente...">{{ old('medicamentos_actuales') }}</textarea>
            </div>
            <div class="form-group">
                <label>Contacto de emergencia</label>
                <input type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia') }}" class="form-control" placeholder="Nombre del familiar">
            </div>
            <div class="form-group">
                <label>Teléfono de emergencia</label>
                <input type="text" name="telefono_emergencia" value="{{ old('telefono_emergencia') }}" class="form-control" placeholder="9XXXXXXXX">
            </div>
        </div>
        <div style="margin-top:14px;">
            <button type="submit" class="btn btn-primary" style="width:100%;">💾 Registrar estudiante</button>
        </div>
    </div>
 
</div>
</form>
@endsection