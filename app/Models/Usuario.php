<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'correo',
        'contraseña',
    ];

    protected $hidden = [
        'contraseña',
    ];

    // Datos estaticos solicitados en la evaluacion (escrito por mi :D)
    public static function datosEstaticos()
    {
        return [
            ['id' => 1, 'nombre' => 'Juan Perez', 'correo' => 'juan@ejemplo.com', 'contraseña' => bcrypt('123456')],
            ['id' => 2, 'nombre' => 'Maria Lopez', 'correo' => 'maria@ejemplo.com', 'contraseña' => bcrypt('123456')],
        ];
    }

    // JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Esta funcion es necesaria para recoger la password de usuario y la retorne de la columna contraseña de la tabla usuarios(escrito por mi no por IA :D).
    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}

