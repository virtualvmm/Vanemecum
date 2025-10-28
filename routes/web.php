<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatogenoController;    // <-- NUEVO: Controlador de Patógenos
use App\Http\Controllers\TratamientoController; // <-- NUEVO: Controlador de Tratamientos
use App\Http\Controllers\GuiaController;        // <-- NUEVO: Controlador de Guía
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puede registrar rutas web para su aplicación.
|
*/

// Ruta de inicio
Route::get('/', function () {
    return view('welcome');
});


// =========================================================================
// GRUPO DE RUTAS AUTENTICADAS (Middleware 'auth' y 'verified' aplicado)
// =========================================================================

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Ruta del Dashboard principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de Perfil (ProfileController)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------------------------------------------------------------------
    // RUTAS DEL MÓDULO MICRO-DB (PATOGENOS)
    // ---------------------------------------------------------------------

    // 1. Catálogo principal de Patógenos (ej. /micros-db)
    Route::get('/micros-db', [PatogenoController::class, 'index'])->name('patogenos.index');

    // 2. Vista de detalle de un Patógeno específico (ej. /micros-db/covid-19)
    Route::get('/micros-db/{slug}', [PatogenoController::class, 'show'])->name('patogenos.show');

    // ---------------------------------------------------------------------
    // RUTAS ADICIONALES PARA EL MENÚ (Asumiendo que existen estos módulos)
    // ---------------------------------------------------------------------
    Route::get('/tratamientos', [TratamientoController::class, 'index'])->name('tratamientos.index');
    Route::get('/guia', [GuiaController::class, 'index'])->name('guia.index');
});

// Incluye las rutas de autenticación (login, register, etc.)
require __DIR__.'/auth.php';
