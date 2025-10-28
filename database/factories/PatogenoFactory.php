<?php

namespace Database\Factories;

use App\Models\Patogeno;
use App\Models\TipoPatogeno;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patogeno>
 */
class PatogenoFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente a este factory.
     * @var string
     */
    protected $model = Patogeno::class;

    /**
     * Define el estado predeterminado del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 1. Obtener un tipo de patógeno válido de la base de datos. 
        // Es crucial que la tabla 'tipo_patogenos' ya esté poblada antes de usar este factory.
        $tipoPatogenoId = TipoPatogeno::inRandomOrder()->first()->id ?? 1;

        // 2. Definir tipos de nombres realistas basados en el ID del tipo (si es posible)
        $patogenoType = match ($tipoPatogenoId) {
            // Asumiendo que el ID 1 es 'Virus'
            1 => $this->faker->randomElement(['Virus de la', 'Rinovirus', 'Adenovirus', 'Orthomyxovirus']),
            // Asumiendo que el ID 2 es 'Bacteria'
            2 => $this->faker->randomElement(['Streptococcus', 'Staphylococcus', 'Salmonella', 'E. coli']),
            // Asumiendo que el ID 3 es 'Hongo'
            3 => $this->faker->randomElement(['Candida', 'Aspergillus', 'Cryptococcus']),
            // Fallback
            default => $this->faker->randomElement(['Agente Patógeno', 'Microorganismo']),
        };

        // 3. Generar el nombre y la descripción
        $nombrePatogeno = $patogenoType . ' ' . $this->faker->unique()->city() . ' Strain ' . $this->faker->randomLetter() . $this->faker->randomNumber(2);

        return [
            // Relacionamos con la clave foránea
            'tipo_patogeno_id' => $tipoPatogenoId, 
            
            // Nombre del patógeno. Usamos .unique() para asegurar que no hay duplicados.
            'nombre' => $nombrePatogeno, 
            
            // Descripción detallada sobre el origen, peligrosidad y características biológicas.
            'descripcion' => 'Descubierto en ' . $this->faker->year() . '. ' . $this->faker->paragraph(4, true) . ' Requiere contención Nivel ' . $this->faker->numberBetween(1, 4) . '.',
        ];
    }
}