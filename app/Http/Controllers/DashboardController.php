<?php

namespace App\Http\Controllers;
use App\Models\Estudiante;
use App\Models\Atencion;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $totalEstudiantes  = Estudiante::count();
        $totalAtenciones   = Atencion::count();
        $atencionesHoy     = Atencion::whereDate('fecha', today())->count();
        $casosRecurrentes  = Atencion::where('es_recurrente', true)->count();
        $ultimasAtenciones = Atencion::with(['estudiante', 'motivo', 'enfermera'])
            ->orderByDesc('fecha')
            ->limit(5)
            ->get();
 
        return view('dashboard', compact(
            'totalEstudiantes', 'totalAtenciones',
            'atencionesHoy', 'casosRecurrentes', 'ultimasAtenciones'
        ));
    }
}
