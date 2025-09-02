<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;
use Illuminate\Http\JsonResponse;



class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Proyectos DB
        $proyectosDB = Proyecto::orderBy('nombre')->get();

        // Proyectos estáticos (array)
        $proyectosEstaticos = Proyecto::datosEstaticos();

        // Convertir array estático a objeto para poder concatenarlo
        $proyectosEstaticosObj = collect(array_map(fn($item) => (object) $item, $proyectosEstaticos));

        // Combinar las dos colecciones
        $proyectosCombinados = $proyectosDB->concat($proyectosEstaticosObj);

        return response()->json([
            'status' => 'success',
            'data' => $proyectosCombinados,
            'message' => 'Lista de proyectos obtenida con éxito',
        ], JsonResponse::HTTP_OK);
    }
        
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'fecha_de_inicio' => 'required|date',
            'estado' => 'required|string',
            'responsable' => 'required|string',
            'monto' => 'required|numeric',
        ]);

        try {
            // Verificar si ya existe un proyecto con el mismo nombre
            $existeProyecto = Proyecto::where('nombre', $request->nombre)->first();

            if ($existeProyecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya existe un proyecto con ese nombre.',
                ], JsonResponse::HTTP_CONFLICT); 
            }

            // Crear nuevo proyecto
            $proyecto = new Proyecto();
            $proyecto->nombre = $request->nombre;
            $proyecto->fecha_de_inicio = $request->fecha_de_inicio;
            $proyecto->estado = $request->estado;
            $proyecto->responsable = $request->responsable;
            $proyecto->monto = $request->monto;
        
            // Asignar el ID del usuario logueado desde JWT
            $proyecto->created_by = auth('api')->id();

            $proyecto->save(); // Guardar

            return response()->json([
                'success' => true,
                'message' => 'Proyecto creado exitosamente.',
                'proyecto' => $proyecto
            ], JsonResponse::HTTP_CREATED); // HTTP 201 Created
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el proyecto: '.$e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR); // HTTP 500 Internal Server Error
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar en DB
        $proyecto = Proyecto::find($id);

        //  Buscar en los datos estáticos
        if (!$proyecto) {
            $proyectoEst = collect(Proyecto::datosEstaticos())->first(function($item) use ($id) {
                return $item['id'] == $id; 
            });

            if ($proyectoEst) {
                // Convertir array estático a objeto
                $proyecto = (object) $proyectoEst;
            }
        }

        // Si no encuentra en ninguna fuente, responder con error 404
        if (!$proyecto) {
            return response()->json(['error' => 'No se encontró proyecto'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retornar el proyecto encontrado
        return response()->json([
            'status' => 'success',
            'data' => $proyecto,
            'message' => 'Proyecto obtenido con éxito',
        ], JsonResponse::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }

        $request->validate([
            'nombre' => 'sometimes|required|string',
            'fecha_inicio' => 'sometimes|required|date',
            'estado' => 'sometimes|required|string',
            'responsable' => 'sometimes|required|string',
            'monto' => 'sometimes|required|numeric',
        ]);

        $proyecto->update($request->only(
            'nombre',
            'fecha_inicio',
            'estado',
            'responsable',
            'monto'));

            return response()->json([
                'status' => 'success',
                'data' => $proyecto,
                'message' => 'Proyecto actualizado con éxito',
            ], JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['message' => 'Proyecto no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }
        $proyecto->delete();
        return response()->json(['message' => 'Proyecto eliminado correctamente'], JsonResponse::HTTP_NO_CONTENT);
    }
}
