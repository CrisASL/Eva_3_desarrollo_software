<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Proyecto extends Model
{
    /** @use HasFactory<\Database\Factories\ProyectoFactory> */
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'estado',
        'responsable',
        'monto',
        'created_by',
    ];

    // Relación con Usuario (responsable)
    public function usuarioCreador()
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }

    // Datos estáticos solicitados (Escrito por mi :D).
    public static function datosEstaticos()
    {
        return [
            [
                'id' => 1,
                'nombre' => 'Proyecto Popi',
                'fecha_inicio' => '2024-01-15',
                'estado' => 'En progreso',
                'responsable' => 'Juan Perez',
                'monto' => 1000000,
                'created_by' => 1,
            ],
            [
                'id' => 2,
                'nombre' => 'Proyecto Salas',
                'fecha_inicio' => '2024-03-01',
                'estado' => 'Terminado',
                'responsable' => 'Maria Lopez',
                'monto' => 500000,
                'created_by' => 2,
            ],
        ];
    }
}
