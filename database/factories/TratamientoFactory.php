<?php

namespace Database\Factories;

use App\Models\Tratamiento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tratamiento>
 */
class TratamientoFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente a este factory.
     * @var string
     */
    protected $model = Tratamiento::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define una variedad de tipos de tratamiento para hacer los datos más realistas.
        $type = $this->faker->randomElement(['Antibiótico', 'Antiviral', 'Terapia Física', 'Vacuna', 'Analgésico', 'Cirugía Menor']);
        
        return [
            // Genera un nombre de tratamiento único y descriptivo
            'nombre' => $type . ' ' . $this->faker->unique()->word() . ' (' . $this->faker->randomNumber(3, true) . ')',
            
            // Descripción detallada del tratamiento o medicamento
            'descripcion' => $this->faker->paragraph(2, true),
            
            // Campo opcional: la duración en días. 
            // Usamos $this->faker->optional(0.7) para que el 30% de las veces sea NULL, 
            // simulando tratamientos que no tienen una duración fija (ej. 'Analgesia bajo demanda').
            'duracion_dias' => $this->faker->optional(0.7)->numberBetween(5, 90), 
        ];
    }
}