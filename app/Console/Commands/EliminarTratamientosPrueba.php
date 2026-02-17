<?php

namespace App\Console\Commands;

use App\Models\Tratamiento;
use Illuminate\Console\Command;

/**
 * Elimina tratamientos de prueba (creados por factory) y deja solo los reales
 * definidos en TratamientoSeeder.
 */
class EliminarTratamientosPrueba extends Command
{
    protected $signature = 'tratamientos:eliminar-prueba
                            {--dry-run : Solo listar lo que se eliminaría}
                            {--force : No preguntar confirmación}';

    protected $description = 'Elimina tratamientos de prueba y deja solo los reales (medicamentos reconocidos).';

    /** Lista de tratamientos reales del TratamientoSeeder */
    private const REALES = [
        'Oseltamivir', 'Aciclovir', 'Ribavirina', 'Valaciclovir',
        'Vacunación antigripal', 'Hidratación y reposo', 'Vacunación',
        'Amoxicilina', 'Azitromicina', 'Metronidazol', 'Ciprofloxacino',
        'Vancomicina', 'Ceftriaxona', 'Clindamicina', 'Tratamiento antituberculoso',
        'Cotrimoxazol', 'Tinidazol', 'Fluconazol', 'Itraconazol', 'Anfotericina B',
        'Cloroquina', 'Arteméter con lumefantrina', 'Primaquina', 'Albendazol',
        'Ivermectina', 'Mebendazol', 'Praziquantel', 'Nitazoxanida', 'Benznidazol',
        'Antimoniales pentavalentes',
    ];

    public function handle(): int
    {
        $realesSet = array_flip(self::REALES);
        $todos = Tratamiento::orderBy('nombre')->get();

        $aEliminar = $todos->filter(fn (Tratamiento $t) => !isset($realesSet[$t->nombre]));

        if ($aEliminar->isEmpty()) {
            $this->info('No hay tratamientos de prueba que eliminar.');
            return self::SUCCESS;
        }

        $this->info('Tratamientos de prueba (se eliminarán): ' . $aEliminar->count());
        foreach ($aEliminar as $t) {
            $this->line('  - ' . $t->nombre);
        }

        if ($this->option('dry-run')) {
            $this->newLine();
            $this->warn('Modo dry-run: no se eliminó nada. Ejecuta sin --dry-run para borrarlos.');
            return self::SUCCESS;
        }

        if (!$this->option('force') && !$this->confirm('¿Eliminar estos ' . $aEliminar->count() . ' tratamientos?')) {
            return self::SUCCESS;
        }

        foreach ($aEliminar as $t) {
            $t->patogenos()->detach();
            $t->delete();
            $this->line('Eliminado: ' . $t->nombre);
        }

        $this->info('Listo. Quedan solo tratamientos reales.');
        return self::SUCCESS;
    }
}
