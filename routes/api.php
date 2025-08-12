<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;

// Ruta para obtener el usuario autenticado (requiere autenticación)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para proyectos
Route::get('/proyectos', [ProyectoController::class, 'getall']); // Obtener todos los proyectos
Route::post('/proyectos', [ProyectoController::class, 'post']); // Crear un nuevo proyecto
Route::get('/proyectos/{id}', [ProyectoController::class, 'get']); // Obtener un proyecto específico
Route::put('/proyectos/{id}', [ProyectoController::class, 'put']); // Actualizar un proyecto
Route::delete('/proyectos/{id}', [ProyectoController::class, 'delete']); // Eliminar un proyecto

