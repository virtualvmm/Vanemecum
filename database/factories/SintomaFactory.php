<?php

namespace Database\Factories;

use App\Models\Sintoma;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sintoma>
 */
class SintomaFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente a este factory.
     * @var string
     */
    protected $model = Sintoma::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista base de síntomas comunes para asegurar nombres realistas.
        $commonSymptoms = [
            'Fiebre', 'Cefalea', 'Dolor de garganta', 'Tos seca', 'Vómitos',
            'Diarrea', 'Erupción cutánea', 'Fatiga extrema', 'Dolor abdominal',
            'Congestión nasal', 'Dolor muscular', 'Náuseas', 'Escalofríos',
            'Ictericia', 'Mareos', 'Insomnio', 'Dolor articular',
        ];

        // 1. Definimos la gravedad (INT 1-5) y la descripción base.
        $gravedad = $this->faker->numberBetween(1, 5); // Nivel de gravedad: 1 (leve) a 5 (crítico)
        
        $descripcionBase = match (true) {
            $gravedad <= 2 => 'Síntoma leve. Suele remitir con descanso y cuidados básicos.',
            $gravedad <= 4 => 'Síntoma moderado a severo. Podría requerir evaluación o tratamiento médico específico.',
            default => 'Síntoma de gravedad crítica. Requiere atención médica inmediata y monitorización.',
        };
        
        // 2. Generamos el nombre del síntoma, asegurando que sea único y definido SIEMPRE.
        
        // CORRECCIÓN 1: Evitamos el OverflowException usando un generador con espacio de búsqueda grande.
        // CORRECCIÓN 2: Asignamos un valor inicial a $nombreSintoma para evitar el error 'Undefined variable'.
        $nombreSintoma = $this->faker->unique()->words(2, true);

        // Si el generador único agota sus opciones, se usa la lista de síntomas comunes como fallback 
        // y se le quita la restricción de unicidad, permitiendo repeticiones para completar los datos de prueba.
        try {
            // Intentamos generar un nombre único usando un generador de frase
            $nombreSintoma = $this->faker->unique()->words(2, true); 
        } catch (\OverflowException $e) {
            // Si no quedan más frases únicas (poco probable), usamos un nombre base de la lista.
            $nombreSintoma = $this->faker->randomElement($commonSymptoms);
        }

        // 3. Añadimos un descriptor aleatorio (40% de probabilidad de concatenación).
        // NOTA: Como $nombreSintoma ya tiene un valor (fue asignado arriba), el operador .= es seguro aquí.
        if ($this->faker->boolean(40)) { // 40% de probabilidad de añadir un descriptor
             $nombreSintoma .= ' (' . $this->faker->randomElement(['agudo', 'persistente', 'localizado', 'generalizado', 'recurrente']) . ')';
        }

        return [
            // $nombreSintoma está garantizada de estar definida aquí.
            'nombre' => $nombreSintoma,
            'gravedad' => $gravedad, 
            // Combinamos la descripción base con una frase de relleno de Faker para generar contenido.
            'descripcion' => $descripcionBase . ' ' . $this->faker->sentence(10),
        ];
    }
}