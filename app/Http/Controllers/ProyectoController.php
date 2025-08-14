<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    
    //Mostrar todos los proyectos (combina estáticos y DB)
    public function getall(Request $request)
    {
        $proyectosDB = Proyecto::all(); // Collection Eloquent
        $proyectosEstaticos = Proyecto::datosEstaticos();

        // Convertir array de estáticos a colección de objetos
        $proyectosEstaticosObj = collect(array_map(fn($item) => (object) $item, $proyectosEstaticos));

        // Combinar colecciones usando concat()
        $proyectosCombinados = $proyectosDB->concat($proyectosEstaticosObj);

        if ($request->wantsJson()) {
            return response()->json($proyectosCombinados);
        }

        return view('showall', ['proyectos' => $proyectosCombinados]);
    }

    
    //Crear un nuevo proyecto en la base de datos
    
    public function post(Request $request) {
    $request->validate([
        'nombre' => 'required|string',
        'fecha_de_inicio' => 'required|date',
        'estado' => 'required|string',
        'responsable' => 'required|string',
        'monto' => 'required|numeric',
    ]);

    $proyecto = new Proyecto();
    $proyecto->nombre = $request->nombre;
    $proyecto->fecha_de_inicio = $request->fecha_de_inicio;
    $proyecto->estado = $request->estado;
    $proyecto->responsable = $request->responsable;
    $proyecto->monto = $request->monto;
    $proyecto->created_by = 1; // O el ID del usuario logueado

    $proyecto->save(); // Guardar en la base de datos

    return redirect()->route('proyectos.showall')->with('success', 'Proyecto creado exitosamente.');
    }

    
    //Obtener un proyecto específico
    
    public function get($id)
    {
    // Primero buscar en la base de datos
    $proyecto = Proyecto::find($id);

    // Si no se encuentra en la base, buscar en los datos estáticos
    if (!$proyecto) {
        $proyecto = collect(Proyecto::datosEstaticos())->first(function($item) use ($id) {
            return $item['id'] == $id; // comparar valor, no tipo
        });

        // Convertir array estático a objeto para la vista
        if ($proyecto) {
            $proyecto = (object) $proyecto;
        }
    }

    // Si aún no se encuentra, redirigir o mostrar mensaje de error
    if (!$proyecto) {
        return redirect()->route('proyectos.showall')->with('error', 'Proyecto no encontrado.');
    }

    return view('show', ['proyecto' => $proyecto]);
    }


    
    //Mostrar formulario de edición
     
    public function edit($id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return redirect()->route('proyectos.showall')->with('error', 'Proyecto no encontrado.');
        }

        return view('update', ['proyecto' => $proyecto]);
    }

    
    //Actualizar proyecto en la base de datos
    
    public function put(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);

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

        $proyecto->update($request->only('nombre','fecha_inicio','estado','responsable','monto'));

        return redirect()->route('proyectos.show', $id)->with('success', 'Proyecto actualizado exitosamente.');
    }

    
    //Eliminar proyecto de la base de datos
    
    public function delete($id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        $proyecto->delete();

        return redirect()->route('proyectos.showall')->with('success', 'Proyecto eliminado.');
    }

    
    //Mostrar formulario para crear un proyecto
     
    public function create()
    {
        return view('make');
    }

    
    //Confirmar eliminación (vista)
    
    public function confirmDelete($id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return redirect()->route('proyectos.showall')->with('error', 'Proyecto no encontrado.');
        }

        return view('delete', ['proyecto' => $proyecto]);
    }
}
