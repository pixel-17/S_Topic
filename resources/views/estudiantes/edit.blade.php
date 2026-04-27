@extends('layouts.app')
@section('title','Editar Estudiante')
@section('page-title','Editar Estudiante')

@section('content')
<div class="page-header">
    <div>
        <h1>Editar: {{ $estudiante->nombre_completo }}</h1>
        <p>DNI: {{ $estudiante->dni }}</p>
    </div>
    <a href="{{ route('estudiantes.show',$estudiante) }}" class="btn btn-outline">← Volver</a>
</div>

<form method="POST" action="{{ route('estudiantes.update',$estudiante) }}">
@csrf @method('PUT')
<div style="display:grid;grid-template-columns:1fr 370px;gap:18px;align-items:start;">
<div>
    <div class="card" style="margin-bottom:16px;">
        <p class="section-title">Datos personales</p>
        <div class="form-grid">
            <div class="form-group">
                <label>DNI <span style="color:var(--danger)">*</span></label>
                <input type="text" name="dni" value="{{ old('dni',$estudiante->dni) }}"
                    class="form-control {{ $errors->has('dni')?'is-invalid':'' }}" maxlength="8">
                @error('dni')<div class="invalid-feedback">⚠ {{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Género</label>
                <select name="genero" class="form-control">
                    <option value="">Seleccionar...</option>
                    <option value="M" {{ old('genero',$estudiante->genero)==='M'?'selected':'' }}>Masculino</option>
                    <option value="F" {{ old('genero',$estudiante->genero)==='F'?'selected':'' }}>Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nombres <span style="color:var(--danger)">*</span></label>
                <input type="text" name="nombres" value="{{ old('nombres',$estudiante->nombres) }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Apellidos <span style="color:var(--danger)">*</span></label>
                <input type="text" name="apellidos" value="{{ old('apellidos',$estudiante->apellidos) }}" class="form-control">
            </div>
             <div class="form-group">
                <label>Correo <span style="color:var(--danger)">*</span></label>
                <input type="email" name="email" value="{{ old('email',$estudiante->email) }}" class="form-control">
            </div>
            <div class="form-group">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                    value="{{ old('fecha_nacimiento',$estudiante->fecha_nacimiento?->format('Y-m-d')) }}"
                    class="form-control"
                    max="{{ now()->subYears(12)->format('Y-m-d') }}"
                    min="{{ now()->subYears(80)->format('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label>Edad</label>
                <input type="text" id="edad-display" class="form-control" disabled
                    value="{{ $estudiante->edad ? $estudiante->edad.' años' : '' }}"
                    style="font-family:'DM Mono',monospace;">
            </div>
            <div class="form-group">
                <label>Carrera</label>
                <select name="carrera_id" class="form-control">
                    <option value="">Seleccionar...</option>
                    @foreach($carreras as $c)
                        <option value="{{ $c->id }}" {{ old('carrera_id',$estudiante->carrera_id)==$c->id?'selected':'' }}>{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Semestre</label>
                <select name="semestre" class="form-control">
                    <option value="">Seleccionar...</option>
                    @foreach(['I','II','III','IV','V','VI'] as $s)
                        <option value="{{ $s }} Semestre"
                            {{ old('semestre',$estudiante->semestre)===$s.' Semestre'?'selected':'' }}>
                            {{ $s }} Semestre
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-span-2">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono',$estudiante->telefono) }}"
                    class="form-control" placeholder="9XXXXXXXX">
            </div>
        </div>
    </div>
</div>

<div>
    <div class="card" style="margin-bottom:14px;">
        <p class="section-title">🩺 Ficha médica</p>
        <div class="form-group">
            <label>Tipo de sangre</label>
            <select name="tipo_sangre" class="form-control">
                <option value="">No especificado</option>
                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $ts)
                    <option value="{{ $ts }}" {{ old('tipo_sangre',$estudiante->fichaMedica?->tipo_sangre)===$ts?'selected':'' }}>{{ $ts }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 12px;">
            <div class="form-group">
                <label>Peso (kg)</label>
                <input type="number" name="peso"
                    value="{{ old('peso',$estudiante->fichaMedica?->peso) }}"
                    class="form-control" step="0.1" min="1" max="300" id="inp-peso">
            </div>
            <div class="form-group">
                <label>Talla (m)</label>
                <input type="number" name="talla"
                    value="{{ old('talla',$estudiante->fichaMedica?->talla) }}"
                    class="form-control" step="0.01" min="0.5" max="2.5" id="inp-talla">
            </div>
        </div>
        <div id="imc-result" style="{{ $estudiante->fichaMedica?->imc?'':'display:none;' }}" class="imc-card">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);margin-bottom:2px;">IMC</div>
                    <div style="font-size:26px;font-weight:700;color:var(--primary);" id="imc-val">{{ $estudiante->fichaMedica?->imc ?? '—' }}</div>
                </div>
                <span class="badge badge-primary" id="imc-badge">{{ $estudiante->fichaMedica?->clasificacion_imc ?? '' }}</span>
            </div>
        </div>
        <div class="form-group" style="margin-top:14px;">
            <label>Alergias conocidas</label>
            <textarea name="alergias" class="form-control" rows="2">{{ old('alergias',$estudiante->fichaMedica?->alergias) }}</textarea>
        </div>
        <div class="form-group">
            <label>Enfermedades previas</label>
            <textarea name="enfermedades_previas" class="form-control" rows="2">{{ old('enfermedades_previas',$estudiante->fichaMedica?->enfermedades_previas) }}</textarea>
        </div>
        <div class="form-group">
            <label>Medicamentos actuales</label>
            <textarea name="medicamentos_actuales" class="form-control" rows="2">{{ old('medicamentos_actuales',$estudiante->fichaMedica?->medicamentos_actuales) }}</textarea>
        </div>
        <div class="form-group">
            <label>Contacto de emergencia</label>
            <input type="text" name="contacto_emergencia"
                value="{{ old('contacto_emergencia',$estudiante->fichaMedica?->contacto_emergencia) }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label>Teléfono de emergencia</label>
            <input type="text" name="telefono_emergencia"
                value="{{ old('telefono_emergencia',$estudiante->fichaMedica?->telefono_emergencia) }}"
                class="form-control">
        </div>
    </div>
    <div style="display:flex;gap:10px;">
        <button type="submit" class="btn btn-primary" style="flex:1;padding:11px;">💾 Guardar cambios</button>
    </div>
</div>
</div>
</form>

<script>
document.getElementById('fecha_nacimiento').addEventListener('change',function(){
    if(!this.value){return;}
    const birth=new Date(this.value),today=new Date();
    let age=today.getFullYear()-birth.getFullYear();
    if(today.getMonth()-birth.getMonth()<0||(today.getMonth()-birth.getMonth()===0&&today.getDate()<birth.getDate()))age--;
    document.getElementById('edad-display').value=age+' años';
});
function calcIMC(){
    const peso=parseFloat(document.getElementById('inp-peso').value);
    const talla=parseFloat(document.getElementById('inp-talla').value);
    const div=document.getElementById('imc-result');
    if(!peso||!talla||talla<=0){div.style.display='none';return;}
    const imc=(peso/(talla*talla)).toFixed(1);
    let cls='',color='';
    if(imc<18.5){cls='Bajo peso';color='#f59e0b';}
    else if(imc<25){cls='Normal ✓';color='#16a34a';}
    else if(imc<30){cls='Sobrepeso';color='#f97316';}
    else{cls='Obesidad';color='#dc2626';}
    document.getElementById('imc-val').textContent=imc;
    const badge=document.getElementById('imc-badge');
    badge.textContent=cls;badge.style.background=color+'20';badge.style.color=color;
    div.style.display='block';
}
document.getElementById('inp-peso').addEventListener('input',calcIMC);
document.getElementById('inp-talla').addEventListener('input',calcIMC);
</script>
@endsection
