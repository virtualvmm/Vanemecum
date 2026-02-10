<?php

namespace App\Console\Commands;

use App\Models\Tratamiento;
use Illuminate\Console\Command;

class EliminarTratamientosInventados extends Command
{
    protected $signature = 'tratamientos:eliminar-inventados';
    protected $description = 'Elimina tratamientos inventados (factory) y deja solo los reales del seeder.';

    /** Nombres de tratamientos reales (TratamientoSeeder / PatogenosCuratedSeeder). */
    protected array $reales = [
        'Oseltamivir', 'Aciclovir', 'Ribavirina', 'Valaciclovir',
        'Vacunación antigripal', 'Hidratación y reposo', 'Vacunación',
        'Amoxicilina', 'Azitromicina', 'Metronidazol', 'Ciprofloxacino',
        'Vancomicina', 'Ceftriaxona', 'Clindamicina',
        'Tratamiento antituberculoso', 'Cotrimoxazol', 'Tinidazol',
        'Fluconazol', 'Itraconazol', 'Anfotericina B',
        'Cloroquina', 'Arteméter con lumefantrina', 'Primaquina',
        'Albendazol', 'Ivermectina', 'Mebendazol', 'Praziquantel',
        'Nitazoxanida', 'Benznidazol', 'Antimoniales pentavalentes',
    ];

    public function handle(): int
    {
        $eliminados = Tratamiento::whereNotIn('nombre', $this->reales)->get();

        if ($eliminados->isEmpty()) {
            $this->info('No hay tratamientos inventados. Solo existen los reales.');
            return self::SUCCESS;
        }

        $count = $eliminados->count();
        foreach ($eliminados as $t) {
            $t->patogenos()->detach();
            $t->delete();
            $this->line("Eliminado: {$t->nombre}");
        }

        $this->info("Se eliminaron {$count} tratamiento(s) inventados. Quedan solo los reales.");
        return self::SUCCESS;
    }
}
