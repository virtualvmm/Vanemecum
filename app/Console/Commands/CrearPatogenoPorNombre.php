<?php

namespace App\Console\Commands;

use App\Models\Patogeno;
use App\Models\TipoPatogeno;
use Illuminate\Console\Command;

class CrearPatogenoPorNombre extends Command
{
    protected $signature = 'patogenos:crear {nombre : Nombre exacto del patógeno}';
    protected $description = 'Crea un patógeno por nombre si no existe (tipo por defecto: primer tipo disponible).';

    public function handle(): int
    {
        $nombre = $this->argument('nombre');
        $tipo = TipoPatogeno::orderBy('id')->first();

        if (!$tipo) {
            $this->error('No hay tipos de patógeno. Ejecuta los seeders.');
            return self::FAILURE;
        }

        $patogeno = Patogeno::firstOrCreate(
            ['nombre' => $nombre],
            [
                'descripcion' => 'Patógeno registrado.',
                'tipo_patogeno_id' => $tipo->id,
                'is_active' => true,
            ]
        );

        if ($patogeno->wasRecentlyCreated) {
            $this->info("Patógeno creado: {$nombre}");
        } else {
            $this->info("El patógeno ya existía: {$nombre}");
        }

        return self::SUCCESS;
    }
}
