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
        return [
            'nombre'     => $this->faker->name(),
            'correo'     => $this->faker->unique()->safeEmail(),
            'contraseña' => Hash::make('123456'),
        ];
    }
}
