<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatogenoController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\GuiaController;
// Importamos el nuevo controlador para Síntomas
use App\Http\Controllers\Admin\SintomaController; 
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
    // RUTAS DEL MÓDULO MICRO-DB (PATOGENOS) - CRUD COMPLETO
    // ---------------------------------------------------------------------

    // 1. Índice de Patógenos (GET: /micros-db)
    Route::get('/micros-db', [PatogenoController::class, 'index'])->name('patogenos.index');

    // 2. Formulario de Creación (GET: /micros-db/create)
    Route::get('/micros-db/create', [PatogenoController::class, 'create'])->name('patogenos.create');

    // 3. Almacenar Patógeno (POST: /micros-db)
    Route::post('/micros-db', [PatogenoController::class, 'store'])->name('patogenos.store');

    // 4. Vista de detalle de un Patógeno (GET: /micros-db/{patogeno})
    Route::get('/micros-db/{patogeno}', [PatogenoController::class, 'show'])->name('patogenos.show');
    
    // 5. Formulario de Edición (GET: /micros-db/{patogeno}/edit)
    Route::get('/micros-db/{patogeno}/edit', [PatogenoController::class, 'edit'])->name('patogenos.edit');

    // 6. Actualizar Patógeno (PUT/PATCH: /micros-db/{patogeno})
    Route::patch('/micros-db/{patogeno}', [PatogenoController::class, 'update'])->name('patogenos.update');
    
    // 7. Eliminar Patógeno (DELETE: /micros-db/{patogeno})
    Route::delete('/micros-db/{patogeno}', [PatogenoController::class, 'destroy'])->name('patogenos.destroy');


    // ---------------------------------------------------------------------
    // RUTAS DEL MÓDULO AUXILIAR: SÍNTOMAS (CRUD)
    // ---------------------------------------------------------------------
    
    // Usamos Route::resource para simplificar la creación de las 7 rutas del CRUD
    Route::resource('admin/sintomas', SintomaController::class)->names('admin.sintomas');
    // Nota: El prefijo de URL es /admin/sintomas
    // Las rutas generadas son: admin.sintomas.index, admin.sintomas.create, admin.sintomas.store, etc.


    // ---------------------------------------------------------------------
    // RUTAS ADICIONALES PARA EL MENÚ 
    // ---------------------------------------------------------------------
    // Tratamientos: definimos recurso completo (index, create, store, show, edit, update, destroy)
    Route::resource('tratamientos', TratamientoController::class)->names('tratamientos');

    // Guía: índice y detalle
    Route::get('/guia', [GuiaController::class, 'index'])->name('guia.index');
    Route::get('/guia/{patogeno}', [GuiaController::class, 'show'])->name('guia.show');
});

// Incluye las rutas de autenticación (login, register, etc.)
require __DIR__.'/auth.php';