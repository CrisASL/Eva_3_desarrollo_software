<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    protected $proyectos = [];

    // Mostrar todos los proyectos
    public function getall(Request $request) {
    // Verificar si la solicitud es AJAX o si se está llamando desde la API
    if ($request->wantsJson()) {
        return response()->json($this->proyectos); // Devuelve todos los proyectos en formato JSON
    }

    return view('showall', ['proyectos' => $this->proyectos]); // Devuelve la vista para la aplicación web
}

    // Crear un nuevo proyecto (para la vista web)
    public function post(Request $request) {
        $request->validate([
            'nombre' => 'required|string',
            'fecha_inicio' => 'required|date',
            'estado' => 'required|string',
            'responsable' => 'required|string',
            'monto' => 'required|numeric',
        ]);

        $id = count($this->proyectos) + 1; // Generación simple de ID
        $proyecto = new Proyecto($id, $request->nombre, $request->fecha_inicio, $request->estado, $request->responsable, $request->monto);
        $this->proyectos[] = $proyecto;

        return redirect()->route('proyectos.showall')->with('success', 'Proyecto creado exitosamente.');
    }

    // Obtener un proyecto específico
    public function get($id) {
        $proyecto = $this->findProyectoById($id);
        
        if (!$proyecto) {
            return view('show', ['error' => 'Proyecto no encontrado.']);
        }

        return view('show', ['proyecto' => $proyecto]);
    }

    // Editar un proyecto (muestra el formulario)
    public function edit($id) {
        $proyecto = $this->findProyectoById($id);
        
        if (!$proyecto) {
            return redirect()->route('proyectos.showall')->with('error', 'Proyecto no encontrado.');
        }

        return view('update', ['proyecto' => $proyecto]);
    }

    // Actualizar un proyecto
    public function put(Request $request, $id) {
        $proyecto = $this->findProyectoById($id);
        
        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string',
            'fecha_inicio' => 'sometimes|required|date',
            'estado' => 'sometimes|required|string',
            'responsable' => 'sometimes|required|string',
            'monto' => 'sometimes|required|numeric',
        ]);

        // Actualizar los campos del proyecto
        $proyecto->nombre = $request->input('nombre', $proyecto->nombre);
        $proyecto->fecha_inicio = $request->input('fecha_inicio', $proyecto->fecha_inicio);
        $proyecto->estado = $request->input('estado', $proyecto->estado);
        $proyecto->responsable = $request->input('responsable', $proyecto->responsable);
        $proyecto->monto = $request->input('monto', $proyecto->monto);

        return redirect()->route('proyectos.show', $id)->with('success', 'Proyecto actualizado exitosamente.');
    }

    // Eliminar un proyecto
    public function delete($id) {
        $proyectoIndex = array_search($this->findProyectoById($id), $this->proyectos);
        if ($proyectoIndex === false) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        array_splice($this->proyectos, $proyectoIndex, 1);
        return redirect()->route('proyectos.showall')->with('success', 'Proyecto eliminado.');
    }

    // Método privado para encontrar un proyecto por ID
    private function findProyectoById($id) {
        foreach ($this->proyectos as $proyecto) {
            if ($proyecto->id == $id) {
                return $proyecto;
            }
        }
        return null; // Retorna null si no se encuentra
    }

    // Mostrar formulario para crear un nuevo proyecto
    public function create() {
        return view('make'); // Carga resources/views/make.blade.php
    }

    public function confirmDelete($id) {
    $proyecto = $this->findProyectoById($id);
    
    if (!$proyecto) {
        return redirect()->route('proyectos.showall')->with('error', 'Proyecto no encontrado.');
    }

    return view('delete', ['proyecto' => $proyecto]);
}
}
