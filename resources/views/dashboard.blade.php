@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

{{-- Bienvenida --}}
<div style="background:linear-gradient(135deg,var(--primary) 0%,var(--accent) 100%);border-radius:14px;padding:24px 28px;margin-bottom:22px;color:#fff;display:flex;align-items:center;justify-content:space-between;overflow:hidden;position:relative;">
    <div style="position:absolute;right:-30px;top:-30px;width:180px;height:180px;background:rgba(255,255,255,.06);border-radius:50%;"></div>
    <div style="position:absolute;right:60px;bottom:-40px;width:120px;height:120px;background:rgba(255,255,255,.04);border-radius:50%;"></div>
    <div style="position:relative;z-index:1;">
        <div style="font-size:13px;opacity:.8;margin-bottom:4px;">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</div>
        <div style="font-size:22px;font-weight:700;line-height:1.2;">Bienvenido, {{ auth()->user()->name }} 👋</div>
        <div style="font-size:13px;opacity:.75;margin-top:4px;">Sistema de Gestión del Tópico — ISTTA "Túpac Amaru"</div>
    </div>
    <div style="position:relative;z-index:1;text-align:right;display:flex;flex-direction:column;align-items:flex-end;gap:8px;">
        <div style="background:rgba(255,255,255,.15);border-radius:10px;padding:10px 16px;backdrop-filter:blur(4px);">
            <div style="font-size:11px;opacity:.7;text-transform:uppercase;letter-spacing:.8px;">Hora actual</div>
            <div style="font-size:22px;font-weight:700;font-family:'DM Mono',monospace;" id="reloj">--:--</div>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="stats-grid" style="margin-bottom:22px;">
    <div class="stat-card" style="border-left:4px solid var(--primary);">
        <div class="stat-icon" style="background:var(--primary-lt);">👥</div>
        <div>
            <div class="value" id="cnt-estudiantes" data-val="{{ $totalEstudiantes }}">0</div>
            <div class="label">Estudiantes</div>
        </div>
    </div>
    <div class="stat-card" style="border-left:4px solid var(--accent);">
        <div class="stat-icon" style="background:var(--accent-lt);">📋</div>
        <div>
            <div class="value" id="cnt-total" data-val="{{ $totalAtenciones }}">0</div>
            <div class="label">Atenciones totales</div>
        </div>
    </div>
    <div class="stat-card" style="border-left:4px solid var(--success);">
        <div class="stat-icon" style="background:var(--success-lt);">🏥</div>
        <div>
            <div class="value" id="cnt-hoy" data-val="{{ $atencionesHoy }}">0</div>
            <div class="label">Atenciones hoy</div>
        </div>
    </div>
    <div class="stat-card" style="border-left:4px solid var(--warn);">
        <div class="stat-icon" style="background:var(--warn-lt);">⚠️</div>
        <div>
            <div class="value" id="cnt-rec" data-val="{{ $casosRecurrentes }}" style="color:#c2410c;">0</div>
            <div class="label">Casos recurrentes</div>
        </div>
    </div>
</div>

{{-- Grid principal --}}
<div style="display:grid;grid-template-columns:1fr 340px;gap:18px;align-items:start;">

    {{-- Últimas atenciones --}}
    <div class="card">
        <div class="page-header" style="margin-bottom:16px;">
            <div>
                <div style="font-size:15px;font-weight:700;">Últimas atenciones</div>
                <div style="font-size:12px;color:var(--muted);">Registros más recientes del tópico</div>
            </div>
            <a href="{{ route('atenciones.create') }}" class="btn btn-primary btn-sm">+ Nueva atención</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th class="num-col">#</th>
                        <th>Estudiante</th>
                        <th>Motivo</th>
                        <th>Enfermera</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimasAtenciones as $i => $at)
                    <tr style="animation:fadeInRow .3s ease {{ $i * 0.06 }}s both;">
                        <td class="num-col">{{ $i + 1 }}</td>
                        <td>
                            <div style="font-weight:500;font-size:13.5px;">{{ $at->estudiante->nombre_completo }}</div>
                            <div style="font-size:11px;color:var(--muted);font-family:'DM Mono',monospace;">{{ $at->estudiante->dni }}</div>
                        </td>
                        <td style="font-size:13px;">{{ $at->motivo->nombre }}</td>
                        <td style="font-size:13px;">{{ $at->enfermera->name }}</td>
                        <td style="font-family:'DM Mono',monospace;font-size:11.5px;color:var(--muted);white-space:nowrap;">{{ $at->fecha->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($at->es_recurrente)
                                <span class="badge badge-warning">⚠ Recurrente</span>
                            @else
                                <span class="badge badge-success">✓ Normal</span>
                            @endif
                        </td>
                        <td><a href="{{ route('atenciones.show',$at) }}" class="btn btn-outline btn-sm">Ver</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center;color:var(--muted);padding:40px;">Sin atenciones registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:12px;text-align:right;">
            <a href="{{ route('atenciones.index') }}" style="font-size:13px;color:var(--accent);font-weight:500;">Ver todas las atenciones →</a>
        </div>
    </div>

    {{-- Panel lateral --}}
    <div style="display:flex;flex-direction:column;gap:14px;">

        {{-- Búsqueda rápida DNI --}}
        <div class="card" style="border-top:3px solid var(--accent);">
            <div style="font-size:13px;font-weight:700;margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                🔍 Búsqueda rápida por DNI
            </div>
            <div id="dni-search-wrap">
                <div style="position:relative;">
                    <input type="text" id="dash-dni" maxlength="8" inputmode="numeric"
                        class="form-control"
                        placeholder="Ingresa 8 dígitos..."
                        style="font-family:'DM Mono',monospace;font-size:15px;letter-spacing:2px;padding-right:44px;transition:all .2s;">
                    <button onclick="dashBuscar()" id="dash-btn-buscar"
                        style="position:absolute;right:6px;top:50%;transform:translateY(-50%);background:var(--accent);border:none;border-radius:6px;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:#fff;transition:all .2s;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    </button>
                </div>
                {{-- Indicador de dígitos --}}
                <div style="display:flex;gap:4px;margin-top:8px;" id="dni-dots">
                    @for($i=0;$i<8;$i++)
                    <div class="dni-dot" style="flex:1;height:3px;background:var(--border);border-radius:2px;transition:background .15s;"></div>
                    @endfor
                </div>
            </div>
            <div id="dash-resultado" style="margin-top:12px;display:none;"></div>
            <div id="dash-spinner" style="display:none;text-align:center;padding:16px;color:var(--muted);font-size:13px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation:spin 1s linear infinite;display:inline-block;"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                Buscando...
            </div>
        </div>

        {{-- Accesos rápidos --}}
        <div class="card">
            <div style="font-size:13px;font-weight:700;margin-bottom:12px;">⚡ Accesos rápidos</div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                <a href="{{ route('atenciones.create') }}" class="quick-link" style="background:var(--primary-lt);color:var(--primary);">
                    <span style="font-size:18px;">🩺</span>
                    <div>
                        <div style="font-weight:600;font-size:13px;">Nueva atención</div>
                        <div style="font-size:11px;opacity:.7;">Registrar consulta médica</div>
                    </div>
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-left:auto;opacity:.5;"><path d="M9 18l6-6-6-6"/></svg>
                </a>
                <a href="{{ route('estudiantes.create') }}" class="quick-link" style="background:var(--accent-lt);color:var(--accent);">
                    <span style="font-size:18px;">👤</span>
                    <div>
                        <div style="font-weight:600;font-size:13px;">Registrar estudiante</div>
                        <div style="font-size:11px;opacity:.7;">Nuevo paciente</div>
                    </div>
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-left:auto;opacity:.5;"><path d="M9 18l6-6-6-6"/></svg>
                </a>
                <a href="{{ route('reportes.index') }}" class="quick-link" style="background:var(--success-lt);color:var(--success);">
                    <span style="font-size:18px;">📊</span>
                    <div>
                        <div style="font-weight:600;font-size:13px;">Ver reportes</div>
                        <div style="font-size:11px;opacity:.7;">Estadísticas del tópico</div>
                    </div>
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-left:auto;opacity:.5;"><path d="M9 18l6-6-6-6"/></svg>
                </a>
            </div>
        </div>

    </div>
</div>

<style>
.quick-link{display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:10px;transition:all .2s;cursor:pointer;}
.quick-link:hover{filter:brightness(.95);transform:translateX(3px);}
@keyframes fadeInRow{from{opacity:0;transform:translateY(8px);}to{opacity:1;transform:translateY(0);}}
@keyframes spin{to{transform:rotate(360deg);}}
@keyframes countUp{from{opacity:0;transform:translateY(10px);}to{opacity:1;transform:translateY(0);}}
.dni-dot.active{background:var(--accent);}
.dni-dot.full{background:var(--success);}
</style>

<script>
// Reloj en tiempo real
function actualizarReloj(){
    const now=new Date();
    document.getElementById('reloj').textContent=
        now.getHours().toString().padStart(2,'0')+':'+
        now.getMinutes().toString().padStart(2,'0')+':'+
        now.getSeconds().toString().padStart(2,'0');
}
actualizarReloj();
setInterval(actualizarReloj,1000);

// Contador animado para stats
function animateCount(el){
    const target=parseInt(el.dataset.val)||0;
    if(target===0){el.textContent='0';return;}
    let current=0;
    const step=Math.max(1,Math.floor(target/40));
    const timer=setInterval(()=>{
        current=Math.min(current+step,target);
        el.textContent=current.toLocaleString();
        if(current>=target)clearInterval(timer);
    },30);
}
document.querySelectorAll('[id^="cnt-"]').forEach(el=>{
    setTimeout(()=>animateCount(el),200);
});

// Indicador de dígitos DNI
const dniInput=document.getElementById('dash-dni');
const dots=document.querySelectorAll('.dni-dot');
dniInput.addEventListener('input',function(){
    const len=this.value.replace(/\D/g,'').length;
    this.value=this.value.replace(/\D/g,'');
    dots.forEach((d,i)=>{
        d.classList.remove('active','full');
        if(i<len) d.classList.add(len===8?'full':'active');
    });
    if(len===8) setTimeout(()=>dashBuscar(),200);
});
dniInput.addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();dashBuscar();}});

async function dashBuscar(){
    const dni=dniInput.value.trim();
    if(dni.length!==8)return;
    const res_div=document.getElementById('dash-resultado');
    const spinner=document.getElementById('dash-spinner');
    res_div.style.display='none';
    spinner.style.display='block';
    document.getElementById('dash-btn-buscar').disabled=true;
    try{
        const res=await fetch(`/estudiantes/buscar/dni?dni=${dni}`);
        const data=await res.json();
        spinner.style.display='none';
        document.getElementById('dash-btn-buscar').disabled=false;
        res_div.style.display='block';
        if(!res.ok){
            res_div.innerHTML=`
                <div style="background:var(--danger-lt);border:1px solid var(--danger);border-radius:9px;padding:12px;">
                    <div style="font-weight:600;color:var(--danger);font-size:13px;margin-bottom:8px;">❌ No encontrado</div>
                    <div style="font-size:12px;color:var(--text2);margin-bottom:10px;">DNI <strong>${dni}</strong> no está registrado.</div>
                    <a href="/estudiantes/create" class="btn btn-primary btn-sm" style="font-size:12px;">+ Registrar</a>
                </div>`;
            return;
        }
        const sangre=data.ficha_medica?.tipo_sangre?`<span class="badge badge-danger" style="font-size:12px;">🩸 ${data.ficha_medica.tipo_sangre}</span>`:'';
        const alergias=data.ficha_medica?.alergias?`<div style="background:var(--warn-lt);border-radius:6px;padding:6px 10px;font-size:11.5px;color:#c2410c;margin-top:6px;">⚠️ ${data.ficha_medica.alergias}</div>`:'';
        res_div.innerHTML=`
            <div style="background:var(--success-lt);border:1.5px solid var(--success);border-radius:10px;padding:14px;animation:fadeInRow .3s ease;">
                <div style="font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px;">${data.nombres} ${data.apellidos}</div>
                <div style="font-size:12px;color:var(--muted);margin-bottom:8px;">DNI: ${data.dni}${data.carrera?' · '+data.carrera.nombre:''}</div>
                <div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:8px;">${sangre}</div>
                ${alergias}
                <div style="display:flex;gap:6px;margin-top:10px;">
                    <a href="/estudiantes/${data.id}" class="btn btn-primary btn-sm" style="font-size:12px;">Ver ficha</a>
                    <a href="/atenciones/create" class="btn btn-accent btn-sm" style="font-size:12px;">+ Atención</a>
                </div>
            </div>`;
        showToast('success','Estudiante encontrado',data.nombres+' '+data.apellidos);
    }catch(e){
        spinner.style.display='none';
        document.getElementById('dash-btn-buscar').disabled=false;
        res_div.style.display='block';
        res_div.innerHTML=`<div class="alert alert-danger">Error de conexión.</div>`;
    }
}
</script>
@endsection
