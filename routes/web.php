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
    // RUTAS DEL MÓDULO MICRO-DB (PATOGENOS) - CRUD COMPLETO (SOLO ADMIN)
    // ---------------------------------------------------------------------
    Route::middleware('is_admin')->group(function () {
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
    });


    // ---------------------------------------------------------------------
    // RUTAS DEL MÓDULO AUXILIAR: SÍNTOMAS (CRUD)
    // ---------------------------------------------------------------------
    
    // Usamos Route::resource para simplificar la creación de las 7 rutas del CRUD (SOLO ADMIN)
    Route::middleware('is_admin')->group(function () {
        Route::resource('admin/sintomas', SintomaController::class)->names('admin.sintomas');
    });
    // Nota: El prefijo de URL es /admin/sintomas
    // Las rutas generadas son: admin.sintomas.index, admin.sintomas.create, admin.sintomas.store, etc.


    // ---------------------------------------------------------------------
    // RUTAS ADICIONALES PARA EL MENÚ 
    // ---------------------------------------------------------------------
    // Tratamientos: index y show públicos; create/store/edit/update/destroy solo admin
    // IMPORTANTE: /create y /store deben ir ANTES de /{tratamiento} para no capturar "create" como ID
    Route::get('/tratamientos', [TratamientoController::class, 'index'])->name('tratamientos.index');
    Route::middleware('is_admin')->group(function () {
        Route::get('/tratamientos/create', [TratamientoController::class, 'create'])->name('tratamientos.create');
        Route::post('/tratamientos', [TratamientoController::class, 'store'])->name('tratamientos.store');
        Route::get('/tratamientos/{tratamiento}/edit', [TratamientoController::class, 'edit'])->name('tratamientos.edit');
        Route::put('/tratamientos/{tratamiento}', [TratamientoController::class, 'update'])->name('tratamientos.update');
        Route::delete('/tratamientos/{tratamiento}', [TratamientoController::class, 'destroy'])->name('tratamientos.destroy');
    });
    Route::get('/tratamientos/{tratamiento}', [TratamientoController::class, 'show'])->name('tratamientos.show');

    // Guía: índice y detalle
    Route::get('/guia', [GuiaController::class, 'index'])->name('guia.index');
    Route::get('/guia/{patogeno}', [GuiaController::class, 'show'])->name('guia.show');
    // Catálogo público completo
    Route::get('/catalogo', [GuiaController::class, 'catalogo'])->name('catalogo.index');
});

// Incluye las rutas de autenticación (login, register, etc.)
require __DIR__.'/auth.php';