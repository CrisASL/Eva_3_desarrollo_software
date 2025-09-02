<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProyectoController;
use App\Http\Controllers\UsuarioController;

// Rutas para usuarios
Route::post('/register', [UsuarioController::class, 'registrar']);
Route::post('/login', [UsuarioController::class, 'IniciarSesion']);

// Rutas protegidas con JWT para proyectos
Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('proyectos', ProyectoController::class);
});

/**
 * Rutas Antiguas
    * Route::get('/proyectos', [ProyectoController::class, 'getall']); // Obtener todos los proyectos
    *Route::post('/proyectos', [ProyectoController::class, 'post']); // Crear un nuevo proyecto
    *Route::get('/proyectos/{id}', [ProyectoController::class, 'get']); // Obtener un proyecto específico
    *Route::put('/proyectos/{id}', [ProyectoController::class, 'put']); // Actualizar un proyecto
    *Route::delete('/proyectos/{id}', [ProyectoController::class, 'delete']); // Eliminar un proyecto
 */
