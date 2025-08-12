<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;

// Ruta principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas para proyectos
Route::get('/proyectos', [ProyectoController::class, 'getall'])->name('proyectos.showall'); // Obtener todos los proyectos
Route::get('/proyectos/create', [ProyectoController::class, 'create'])->name('proyectos.create'); // Mostrar formulario para crear un nuevo proyecto
Route::post('/proyectos', [ProyectoController::class, 'post'])->name('proyectos.store'); // Crear un nuevo proyecto
Route::get('/proyectos/{id}', [ProyectoController::class, 'get'])->name('proyectos.show'); // Obtener un proyecto específico
Route::get('/proyectos/{id}/edit', [ProyectoController::class, 'edit'])->name('proyectos.edit'); // Mostrar formulario para editar un proyecto
Route::put('/proyectos/{id}', [ProyectoController::class, 'put'])->name('proyectos.update'); // Actualizar un proyecto
Route::get('/proyectos/{id}/delete', [ProyectoController::class, 'confirmDelete'])->name('proyectos.confirmDelete'); // Confirmar eliminación de un proyecto
Route::delete('/proyectos/{id}', [ProyectoController::class, 'delete'])->name('proyectos.delete'); // Eliminar un proyecto