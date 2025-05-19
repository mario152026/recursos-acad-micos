<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\ValoracionComentarioController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

// Página de inicio
Route::get('/', [PagesController::class, 'home'])
    ->name('home');

// Exploración general de recursos (pública y autenticada)
Route::get('recursos', [RecursoController::class, 'index'])
    ->name('recursos.index');

// Detalle de recurso (solo numéricos para no chocar con "create")
Route::get('recursos/{recurso}', [RecursoController::class, 'show'])
    ->whereNumber('recurso')
    ->name('recursos.show');

require __DIR__.'/auth.php'; // login, register, etc.

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren autenticación)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Perfil de usuario
    Route::get('/profile',   [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // CRUD de recursos (excepto index y show, que ya están arriba)
    Route::resource('recursos', RecursoController::class)
        ->except(['index', 'show']);

    // “Mis recursos”
    Route::get('mis-recursos', [RecursoController::class, 'myResources'])
        ->name('recursos.mine');

    // Valoraciones de recursos
    Route::post('recursos/{recurso}/valoraciones', [ValoracionComentarioController::class, 'store'])
        ->name('recursos.valoraciones.store');

    // Reportes de recursos (frontend)
    Route::post('recursos/{recurso}/reportes', [ReporteController::class, 'store'])
        ->name('recursos.reportes.store');
});

/*
|--------------------------------------------------------------------------
| Panel de administración (requiere rol admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\Admin\RecursoController::class, 'index'])
            ->name('home');

        // Gestión de recursos
        Route::resource('recursos', \App\Http\Controllers\Admin\RecursoController::class)
            ->only(['index', 'destroy']);
        Route::patch('recursos/{recurso}/toggle', [
            \App\Http\Controllers\Admin\RecursoController::class,
            'toggleActivo',
        ])->name('recursos.toggle');

        // Gestión de reportes
        Route::resource('reportes', \App\Http\Controllers\Admin\ReporteController::class)
            ->only(['index','destroy']);
        Route::patch('reportes/{reporte}/resuelto', [
            \App\Http\Controllers\Admin\ReporteController::class,
            'markResolved',
        ])->name('reportes.resuelto');

        // Gestión de usuarios
        Route::get('usuarios', [\App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('usuarios.index');
        Route::patch('usuarios/{usuario}/toggle', [
            \App\Http\Controllers\Admin\UserController::class,
            'toggleActivo',
        ])->name('usuarios.toggle');
        Route::patch('usuarios/{usuario}/role', [
            \App\Http\Controllers\Admin\UserController::class,
            'setRole',
        ])->name('usuarios.role');
        Route::delete('usuarios/{usuario}', [
            \App\Http\Controllers\Admin\UserController::class,
            'destroy',
        ])->name('usuarios.destroy');

        // Ajustes globales
        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'edit'])
            ->name('settings.edit');
        Route::patch('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])
            ->name('settings.update');
    });
