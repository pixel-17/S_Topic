@extends('layouts.app')
@section('title','Nuevo Estudiante')
@section('page-title','Nuevo Estudiante')

@section('content')
<div class="page-header">
    <div><h1>Registrar Estudiante</h1><p>Completa los datos personales y la ficha médica</p></div>
    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline">← Volver</a>
</div>

<form method="POST" action="{{ route('estudiantes.store') }}" id="form-est">
@csrf
<div style="display:grid;grid-template-columns:1fr 370px;gap:18px;align-items:start;">
<div>
    <div class="card" style="margin-bottom:16px;">
        <p class="section-title">Datos personales</p>
        <div class="form-grid">
            <div class="form-group">
                <label>DNI <span style="color:var(--danger)">*</span></label>
                <input type="text" name="dni" value="{{ old('dni') }}"
                    class="form-control {{ $errors->has('dni')?'is-invalid':'' }}"
                    maxlength="8" placeholder="12345678" inputmode="numeric" pattern="[0-9]{8}">
                @error('dni')<div class="invalid-feedback">⚠ {{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Género</label>
                <select name="genero" class="form-control">
                    <option value="">Seleccionar...</option>
                    <option value="M" {{ old('genero')==='M'?'selected':'' }}>Masculino</option>
                    <option value="F" {{ old('genero')==='F'?'selected':'' }}>Femenino</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nombres <span style="color:var(--danger)">*</span></label>
                <input type="text" name="nombres" value="{{ old('nombres') }}"
                    class="form-control {{ $errors->has('nombres')?'is-invalid':'' }}">
                @error('nombres')<div class="invalid-feedback">⚠ {{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Apellidos <span style="color:var(--danger)">*</span></label>
                <input type="text" name="apellidos" value="{{ old('apellidos') }}"
                    class="form-control {{ $errors->has('apellidos')?'is-invalid':'' }}">
                @error('apellidos')<div class="invalid-feedback">⚠ {{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                    value="{{ old('fecha_nacimiento') }}"
                    class="form-control {{ $errors->has('fecha_nacimiento')?'is-invalid':'' }}"
                    max="{{ now()->subYears(12)->format('Y-m-d') }}"
                    min="{{ now()->subYears(80)->format('Y-m-d') }}">
                <div style="font-size:11px;color:var(--muted);margin-top:3px;">Edad mínima: 12 años</div>
                @error('fecha_nacimiento')<div class="invalid-feedback">⚠ {{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Edad calculada</label>
                <input type="text" id="edad-display" class="form-control" disabled
                    placeholder="Automático" style="font-family:'DM Mono',monospace;">
            </div>
            <div class="form-group">
                <label>Carrera</label>
                <select name="carrera_id" class="form-control">
                    <option value="">Seleccionar...</option>
                    @foreach($carreras as $c)
                        <option value="{{ $c->id }}" {{ old('carrera_id')==$c->id?'selected':'' }}>{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Semestre</label>
                <select name="semestre" class="form-control">
                    <option value="">Seleccionar...</option>
                    @foreach(['I','II','III','IV','V','VI'] as $s)
                        <option value="{{ $s }} Semestre" {{ old('semestre')===$s.' Semestre'?'selected':'' }}>{{ $s }} Semestre</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-span-2">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}"
                    class="form-control" placeholder="9XXXXXXXX" inputmode="numeric">
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
                    <option value="{{ $ts }}" {{ old('tipo_sangre')===$ts?'selected':'' }}>{{ $ts }}</option>
                @endforeach
            </select>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 12px;">
            <div class="form-group">
                <label>Peso (kg)</label>
                <input type="number" name="peso" value="{{ old('peso') }}"
                    class="form-control" step="0.1" min="1" max="300" placeholder="65.5" id="inp-peso">
            </div>
            <div class="form-group">
                <label>Talla (m)</label>
                <input type="number" name="talla" value="{{ old('talla') }}"
                    class="form-control" step="0.01" min="0.5" max="2.5" placeholder="1.70" id="inp-talla">
            </div>
        </div>
        <div id="imc-result" style="display:none;" class="imc-card">
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);margin-bottom:2px;">IMC calculado</div>
                    <div style="font-size:26px;font-weight:700;color:var(--primary);" id="imc-val">—</div>
                </div>
                <span class="badge" id="imc-badge">—</span>
            </div>
        </div>
        <div class="form-group" style="margin-top:14px;">
            <label>Alergias conocidas</label>
            <textarea name="alergias" class="form-control" rows="2"
                placeholder="Ej: Penicilina, ácaros...">{{ old('alergias') }}</textarea>
        </div>
        <div class="form-group">
            <label>Enfermedades previas</label>
            <textarea name="enfermedades_previas" class="form-control" rows="2"
                placeholder="Ej: Asma, diabetes...">{{ old('enfermedades_previas') }}</textarea>
        </div>
        <div class="form-group">
            <label>Medicamentos actuales</label>
            <textarea name="medicamentos_actuales" class="form-control" rows="2"
                placeholder="Medicamentos actuales...">{{ old('medicamentos_actuales') }}</textarea>
        </div>
        <div class="form-group">
            <label>Contacto de emergencia</label>
            <input type="text" name="contacto_emergencia" value="{{ old('contacto_emergencia') }}"
                class="form-control" placeholder="Nombre del familiar">
        </div>
        <div class="form-group">
            <label>Teléfono de emergencia</label>
            <input type="text" name="telefono_emergencia" value="{{ old('telefono_emergencia') }}"
                class="form-control" placeholder="9XXXXXXXX">
        </div>
    </div>
    <button type="submit" class="btn btn-primary" style="width:100%;padding:11px;font-size:14px;">
        💾 Registrar estudiante
    </button>
</div>
</div>
</form>

<script>
document.getElementById('fecha_nacimiento').addEventListener('change',function(){
    if(!this.value){document.getElementById('edad-display').value='';return;}
    const birth=new Date(this.value),today=new Date();
    let age=today.getFullYear()-birth.getFullYear();
    const m=today.getMonth()-birth.getMonth();
    if(m<0||(m===0&&today.getDate()<birth.getDate()))age--;
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
    badge.textContent=cls;
    badge.style.background=color+'20';
    badge.style.color=color;
    div.style.display='block';
}
document.getElementById('inp-peso').addEventListener('input',calcIMC);
document.getElementById('inp-talla').addEventListener('input',calcIMC);
</script>
@endsection
