<?php

namespace App\Console\Commands;

use App\Models\Patogeno;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AsignarImagenesPatogenos extends Command
{
    protected $signature = 'patogenos:asignar-imagenes';
    protected $description = 'Asigna las imágenes de public/images/patogenos a patógenos por coincidencia de nombre (nombre del archivo sin extensión = nombre del patógeno).';

    public function handle(): int
    {
        $carpeta = public_path('images/patogenos');

        if (!File::isDirectory($carpeta)) {
            $this->error("No existe la carpeta: {$carpeta}");
            return self::FAILURE;
        }

        $archivos = File::files($carpeta);
        $extensiones = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        $asignados = 0;

        foreach ($archivos as $file) {
            $nombreArchivo = $file->getFilename();
            if ($nombreArchivo === '.gitkeep') {
                continue;
            }

            $extension = strtolower($file->getExtension());
            if (!in_array($extension, $extensiones)) {
                continue;
            }

            // Nombre del archivo sin extensión = nombre del patógeno
            $nombrePatogeno = pathinfo($nombreArchivo, PATHINFO_FILENAME);

            $patogeno = Patogeno::where('nombre', $nombrePatogeno)->first();

            if (!$patogeno) {
                $this->warn("No se encontró patógeno con nombre: \"{$nombrePatogeno}\"");
                continue;
            }

            $url = '/images/patogenos/' . rawurlencode($nombreArchivo);
            $patogeno->image_url = $url;
            $patogeno->save();
            $this->line("✓ {$patogeno->nombre} → {$nombreArchivo}");
            $asignados++;
        }

        $this->info("Se asignaron {$asignados} imagen(es) a sus patógenos.");
        return self::SUCCESS;
    }
}
