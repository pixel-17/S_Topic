<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\AtencionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

// Ruta raíz → login
Route::get('/', fn() => redirect()->route('login'));
 
// Rutas protegidas (usuario autenticado)
Route::middleware(['auth', 'verified'])->group(function () {
 
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
 
    // Estudiantes
    Route::resource('estudiantes', EstudianteController::class);
    Route::get('/estudiantes/buscar/dni', [EstudianteController::class, 'buscarPorDni'])->name('estudiantes.buscarDni');
 
    // Atenciones
   Route::resource('atenciones', AtencionController::class)
    ->parameters(['atenciones' => 'atencion']);
    Route::get('/estudiantes/{estudiante}/historial', [AtencionController::class, 'historial'])->name('atenciones.historial');
    Route::get('/estudiantes/{estudiante}/reporte', [AtencionController::class, 'reporte'])->name('atenciones.reporte');
 
    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
 
    // Solo admin
    Route::middleware('auth','solo.admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show', 'destroy']);
        Route::patch('/users/{user}/toggle', [UserController::class, 'toggleActivo'])->name('users.toggle');
    });
    
});