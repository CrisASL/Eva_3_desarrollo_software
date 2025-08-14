<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    
    protected $model = Usuario::class;
    
    public function definition(): array
    {
        static $idCounter = 3; // Empezar desde 3 para no pisar los datos estáticos

        return [
            'id' => $idCounter++, // Incrementa el contador y asigna un nuevo ID
            'nombre'     => $this->faker->name(), // Genera un nombre aleatorio
            'correo'     => $this->faker->unique()->safeEmail(), // Genera un correo electrónico único aleatorio
            'contraseña' => Hash::make('123456'), // Contraseña encriptada
        ];
    }
}
