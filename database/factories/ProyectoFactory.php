<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Proyecto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proyecto>
 */
class ProyectoFactory extends Factory
{
    protected $model = Proyecto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $idCounter = 3; // Empezar desde 3 para no pisar los datos estáticos

        return [
            'id' => $idCounter++, // Auto-incrementar ID a partir de 3
            'nombre' => $this->faker->sentence(3), // Nombre del proyecto
            'fecha_de_inicio' => $this->faker->date('Y-m-d', 'now'), // Fecha de inicio
            'estado' => $this->faker->randomElement(['En progreso', 'Terminado']),
            'responsable' => $this->faker->name, // Nombre del responsable
            'monto' => $this->faker->numberBetween(100000, 5000000), // Monto aleatorio
            'created_by' => $this->faker->numberBetween(3, 7), // ID de usuario creador
        ];
    }
}

