<?php

namespace App\Console\Commands;

use App\Models\Patogeno;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AsignarImagenesPatogenos extends Command
{
    protected $signature = 'patogenos:asignar-imagenes
                            {--report : Solo listar patógenos sin imagen e imágenes sin asignar}';

    protected $description = 'Asigna las imágenes de public/images/patogenos a patógenos por coincidencia de nombre.';

    public function handle(): int
    {
        $carpeta = public_path('images/patogenos');

        if (!File::isDirectory($carpeta)) {
            $this->error("No existe la carpeta: {$carpeta}");
            return self::FAILURE;
        }

        $todosPatogenos = Patogeno::orderBy('nombre')->get();
        $patogenosPorNombre = $todosPatogenos->keyBy('nombre');
        $patogenosPorNormalizado = $todosPatogenos->keyBy(fn (Patogeno $p) => $this->normalizarNombre($p->nombre));

        $archivos = File::files($carpeta);
        $extensiones = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

        if ($this->option('report')) {
            $conImagen = $todosPatogenos->filter(fn (Patogeno $p) => !empty(trim((string) $p->image_url)));
            $sinImagen = $todosPatogenos->filter(fn (Patogeno $p) => empty(trim((string) $p->image_url)));
            $this->info('Patógenos con imagen: ' . $conImagen->count());
            $this->info('Patógenos SIN imagen: ' . $sinImagen->count());
            if ($sinImagen->isNotEmpty()) {
                $this->newLine();
                $this->warn('Patógenos sin foto:');
                foreach ($sinImagen as $p) {
                    $this->line('  - ' . $p->nombre);
                }
            }
            $this->newLine();
            return self::SUCCESS;
        }

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

            $nombreSinExtension = pathinfo($nombreArchivo, PATHINFO_FILENAME);

            $patogeno = $patogenosPorNombre->get($nombreSinExtension)
                ?? $patogenosPorNormalizado->get($this->normalizarNombre($nombreSinExtension))
                ?? $this->buscarPatogenoPorInicioDeNombre($nombreSinExtension, $todosPatogenos);

            if (!$patogeno) {
                $this->warn("No se encontró patógeno con nombre: \"{$nombreSinExtension}\"");
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

    private function normalizarNombre(string $nombre): string
    {
        $n = Str::ascii($nombre);
        $n = trim(preg_replace('/\s+/', ' ', $n));
        return $n;
    }

    /** Busca un patógeno cuyo nombre sea el inicio del nombre del archivo (ej. "Adenovirus" para "Adenovirus Fritschfurt Strain b90"). */
    private function buscarPatogenoPorInicioDeNombre(string $nombreArchivo, $todosPatogenos): ?Patogeno
    {
        $nombreNorm = $this->normalizarNombre($nombreArchivo);
        $mejor = null;
        $mejorLongitud = 0;
        foreach ($todosPatogenos as $p) {
            $patNorm = $this->normalizarNombre($p->nombre);
            if ($patNorm !== '' && Str::startsWith($nombreNorm, $patNorm) && strlen($patNorm) > $mejorLongitud) {
                $mejor = $p;
                $mejorLongitud = strlen($patNorm);
            }
        }
        return $mejor;
    }
}
