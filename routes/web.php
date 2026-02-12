<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatogenoController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\GuiaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\Admin\SintomaController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\AlertaController;
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
    // RUTAS DEL MÓDULO AUXILIAR: SÍNTOMAS, MENSAJES, ALERTAS (SOLO ADMIN)
    // ---------------------------------------------------------------------
    Route::middleware('is_admin')->group(function () {
        Route::resource('admin/sintomas', SintomaController::class)->names('admin.sintomas');

        // Mensajes de contacto (formulario de usuarios)
        Route::get('admin/mensajes', [ContactMessageController::class, 'index'])->name('admin.mensajes.index');
        Route::get('admin/mensajes/{mensaje}', [ContactMessageController::class, 'show'])->name('admin.mensajes.show');
        Route::patch('admin/mensajes/{mensaje}/leido', [ContactMessageController::class, 'toggleLeido'])->name('admin.mensajes.toggle-leido');

        // Módulo de Alertas: patógenos con alerta activa
        Route::get('admin/alertas', [AlertaController::class, 'index'])->name('admin.alertas.index');
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

    // Mis patógenos (favoritos) - todos los usuarios autenticados
    Route::get('/mis-patogenos', [FavoritoController::class, 'index'])->name('favoritos.index');
    Route::post('/mis-patogenos/{patogeno}', [FavoritoController::class, 'store'])->name('favoritos.store');
    Route::delete('/mis-patogenos/{patogeno}', [FavoritoController::class, 'destroy'])->name('favoritos.destroy');

    // Contacto: reportar error, sugerir patógeno, etc. (envía email al admin)
    Route::get('/contacto', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');
});

// Incluye las rutas de autenticación (login, register, etc.)
require __DIR__.'/auth.php';