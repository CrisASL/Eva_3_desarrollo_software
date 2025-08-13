<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function registrar(Request $request)
    {
        try {
            $request->validate([
                'nombre'     => 'required|string|max:255',
                'correo'     => 'required|string|email|max:255|unique:usuarios,correo',
                'contraseña' => 'required|string|min:6',
            ]);

            $usuario = Usuario::create([
                'nombre'     => $request->nombre,
                'correo'     => $request->correo,
                'contraseña' => Hash::make($request->contraseña),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario registrado correctamente',
                'usuario' => $usuario,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
        ], 422);
        } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error inesperado al registrar usuario',
        ], 500);
        }
    }

    public function IniciarSesion(Request $request)
    {
        try {
            $credentials = $request->only('correo', 'contraseña');

            if (!$token = Auth::guard('api')->attempt([
                'correo' => $credentials['correo'],
                'password' => $credentials['contraseña'], // Laravel espera 'password', es importante que coincida con el campo en la base de datos(escrito por mi no por IA :D).
            ])) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }

            return response()->json([
                'success' => true,
                'token' => $token,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
        ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error inesperado al iniciar sesión',
            ], 500);
        }
    }
}
