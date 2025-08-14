<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

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
            // Validamos que lleguen los datos
            $request->validate([
                'correo' => 'required|email',
                'contraseña' => 'required|string',
            ]);

            $credentials = $request->only('correo', 'contraseña');

            // Buscamos al usuario por correo
            $usuario = Usuario::where('correo', $credentials['correo'])->first();

            if (!$usuario || !Hash::check($credentials['contraseña'], $usuario->contraseña)) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }

            // Generamos el token JWT para este usuario
            $token = JWTAuth::fromUser($usuario);

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
