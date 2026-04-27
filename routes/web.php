<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\AtencionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));
// Recuperación de contraseña
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.send');
Route::get('/forgot-password', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    // Estudiantes
    Route::resource('estudiantes', EstudianteController::class);
    Route::get('/estudiantes/buscar/dni', [EstudianteController::class,'buscarPorDni'])->name('estudiantes.buscarDni');

    // Atenciones — editar/actualizar/eliminar solo admin
    Route::resource('atenciones', AtencionController::class)
        ->parameters(['atenciones' => 'atencion'])
        ->except(['edit','update','destroy']);
    Route::get('/atenciones/{atencion}/edit',    [AtencionController::class,'edit'])->name('atenciones.edit')->middleware('solo.admin');
    Route::put('/atenciones/{atencion}',         [AtencionController::class,'update'])->name('atenciones.update')->middleware('solo.admin');
    Route::delete('/atenciones/{atencion}',      [AtencionController::class,'destroy'])->name('atenciones.destroy')->middleware('solo.admin');

    Route::get('/estudiantes/{estudiante}/historial', [AtencionController::class,'historial'])->name('atenciones.historial');
    Route::get('/estudiantes/{estudiante}/reporte',   [AtencionController::class,'reporte'])->name('atenciones.reporte');

    // Reportes
    Route::get('/reportes', [ReporteController::class,'index'])->name('reportes.index');

    // Perfil
    Route::get('/perfil',          [PerfilController::class,'edit'])->name('perfil.edit');
    Route::put('/perfil/password', [PerfilController::class,'updatePassword'])->name('perfil.password');
    Route::put('/perfil/tema',     [PerfilController::class,'updateTema'])->name('perfil.tema');

    // Solo admin
    Route::middleware('solo.admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show','destroy']);
        Route::patch('/users/{user}/toggle', [UserController::class,'toggleActivo'])->name('users.toggle');
    });

});
