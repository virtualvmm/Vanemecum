<?php

namespace App\Console\Commands;

use App\Models\Patogeno;
use Illuminate\Console\Command;

/**
 * Elimina patógenos que no tienen imagen y cuyo nombre parece de prueba
 * (contienen "Strain", "prueba", "Agente Patógeno", "Microorganismo", etc.).
 * Así la guía solo muestra patógenos reales con foto.
 */
class EliminarPatogenosPruebaSinImagen extends Command
{
    protected $signature = 'patogenos:eliminar-prueba-sin-imagen
                            {--dry-run : Solo listar lo que se eliminaría, sin borrar}
                            {--force : No preguntar confirmación}';

    protected $description = 'Elimina patógenos de prueba sin imagen (nombres con Strain, prueba, etc.).';

    public function handle(): int
    {
        $sinImagen = Patogeno::where(function ($q) {
            $q->whereNull('image_url')->orWhere('image_url', '');
        })->get();

        $patrones = ['Strain', 'prueba', 'Agente Patógeno', 'Microorganismo', 'Orthomyxovirus Lake', 'Orthomyxovirus West', 'Virus de la Port', 'Virus de la Raegan', 'E. coli Flatley', 'E. coli Jast', 'Rinovirus East', 'Rinovirus New', 'Aspergillus New', 'Aspergillus Oberbrunner', 'Candida Lueilwitz', 'Candida South', 'Cryptococcus Lake', 'Cryptococcus Mabel', 'Cryptococcus Vest', 'Cryptococcus West', 'Salmonella Court', 'Salmonella New Ahmed', 'Salmonella New Amiya', 'Salmonella North', 'Streptococcus Alfred', 'Streptococcus Kaitlin'];

        $aEliminar = $sinImagen->filter(function (Patogeno $p) use ($patrones) {
            foreach ($patrones as $patron) {
                if (str_contains($p->nombre, $patron)) {
                    return true;
                }
            }
            return false;
        });

        if ($aEliminar->isEmpty()) {
            $this->info('No hay patógenos de prueba sin imagen que eliminar.');
            return self::SUCCESS;
        }

        $this->info('Patógenos sin imagen que parecen de prueba: ' . $aEliminar->count());
        foreach ($aEliminar as $p) {
            $this->line('  - ' . $p->nombre);
        }

        if ($this->option('dry-run')) {
            $this->newLine();
            $this->warn('Modo dry-run: no se eliminó nada. Ejecuta sin --dry-run para borrarlos.');
            return self::SUCCESS;
        }

        if (!$this->option('force') && !$this->confirm('¿Eliminar estos ' . $aEliminar->count() . ' patógenos?')) {
            return self::SUCCESS;
        }

        foreach ($aEliminar as $p) {
            $p->tratamientos()->detach();
            $p->sintomas()->detach();
            $p->delete();
            $this->line('Eliminado: ' . $p->nombre);
        }

        $this->info('Listo. Quedan solo patógenos con imagen o con nombres reales.');
        return self::SUCCESS;
    }
}
