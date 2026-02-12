<?php

namespace App\Console\Commands;

use App\Models\Patogeno;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SincronizarAlertasOms extends Command
{
    /**
     * Firma del comando.
     *
     * Ejemplo de uso:
     *  php artisan alertas:sincronizar-oms
     */
    protected $signature = 'alertas:sincronizar-oms
                            {--days=60 : Días hacia atrás que se consideran recientes en las noticias de la OMS}';

    protected $description = 'Sincroniza automáticamente las alertas de patógenos usando las Disease Outbreak News oficiales de la OMS.';

    /**
     * Endpoint oficial de la OMS para Disease Outbreak News (DONs).
     * Ver: https://www.who.int/api/news/diseaseoutbreaknews
     */
    protected string $whoEndpoint = 'https://www.who.int/api/news/diseaseoutbreaknews';

    public function handle(): int
    {
        $days = (int) $this->option('days') ?: 60;

        $this->info("Consultando Disease Outbreak News de la OMS (últimos {$days} días)...");

        try {
            $response = Http::timeout(15)->get($this->whoEndpoint);
        } catch (\Throwable $e) {
            $this->error('No se pudo contactar con la OMS: ' . $e->getMessage());
            return self::FAILURE;
        }

        if (! $response->ok()) {
            $this->error('La OMS devolvió un código de error: ' . $response->status());
            return self::FAILURE;
        }

        $data = $response->json();
        $items = Arr::get($data, 'value', []);

        if (empty($items)) {
            $this->warn('La respuesta de la OMS no contiene elementos de Disease Outbreak News.');
            return self::SUCCESS;
        }

        $cutoff = now()->subDays($days);

        // Nos quedamos solo con noticias recientes
        $recent = collect($items)->filter(function ($item) use ($cutoff) {
            $date = Arr::get($item, 'PublicationDateAndTime') ?? Arr::get($item, 'PublicationDate');
            if (! $date) {
                return false;
            }
            try {
                return now()->parse($date)->greaterThanOrEqualTo($cutoff);
            } catch (\Throwable $e) {
                return false;
            }
        })->values();

        if ($recent->isEmpty()) {
            $this->info('No hay noticias recientes de la OMS en el rango indicado.');
            return self::SUCCESS;
        }

        $this->line('Noticias recientes de la OMS: ' . $recent->count());

        // Indexamos textos (título + resumen) en minúsculas para hacer matching simple
        $donTexts = $recent->map(function ($item) {
            $title = Str::lower(Arr::get($item, 'Title', ''));
            $overview = Str::lower(Arr::get($item, 'Overview', ''));
            $summary = Str::lower(Arr::get($item, 'Summary', ''));

            return [
                'title' => $title,
                'overview' => $overview,
                'summary' => $summary,
                'full_text' => $title . ' ' . $overview . ' ' . $summary,
                'url' => 'https://www.who.int' . Arr::get($item, 'ItemDefaultUrl', ''),
            ];
        });

        // 1) Desactivar todas las alertas antes de recalcular
        Patogeno::where('alerta_activa', true)->update([
            'alerta_activa' => false,
            'alerta_texto' => null,
        ]);

        $this->line('Alertas anteriores desactivadas. Calculando nuevas alertas según OMS...');

        $totalMarcados = 0;

        Patogeno::chunk(50, function ($patogenos) use (&$totalMarcados, $donTexts) {
            foreach ($patogenos as $patogeno) {
                $keywords = $this->buildKeywordsForPatogeno($patogeno->nombre);

                $match = $donTexts->first(function ($don) use ($keywords) {
                    foreach ($keywords as $kw) {
                        if ($kw !== '' && Str::contains($don['full_text'], $kw)) {
                            return true;
                        }
                    }
                    return false;
                });

                if ($match) {
                    $patogeno->alerta_activa = true;
                    $patogeno->alerta_texto = sprintf(
                        'Alerta OMS activa relacionada con este patógeno. Consulte la nota oficial: %s',
                        $match['url']
                    );
                    $patogeno->save();
                    $this->line("✓ Alerta activada para: {$patogeno->nombre}");
                    $totalMarcados++;
                }
            }
        });

        if ($totalMarcados === 0) {
            $this->info('No se ha activado ninguna alerta basada en las noticias recientes de la OMS.');
        } else {
            $this->info("Se han activado alertas para {$totalMarcados} patógeno(s) según la OMS.");
        }

        return self::SUCCESS;
    }

    /**
     * Genera palabras clave aproximadas para intentar emparejar
     * el nombre del patógeno (en castellano/latín) con los títulos
     * en inglés de la OMS.
     */
    protected function buildKeywordsForPatogeno(string $nombre): array
    {
        $base = Str::lower($nombre);

        // Eliminamos acentos básicos
        $base = Str::of($base)
            ->replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'])
            ->value();

        $keywords = [];

        // 1) Palabras clave según patrones comunes en nombres
        if (Str::startsWith($base, 'virus de la ')) {
            $keywords[] = trim(Str::after($base, 'virus de la ')); // p.ej. "influenza a"
        } elseif (Str::startsWith($base, 'virus del ')) {
            $keywords[] = trim(Str::after($base, 'virus del ')); // p.ej. "dengue"
        } elseif (Str::startsWith($base, 'virus de ')) {
            $keywords[] = trim(Str::after($base, 'virus de '));
        } elseif (Str::startsWith($base, 'bacteria ')) {
            $keywords[] = trim(Str::after($base, 'bacteria '));
        }

        // 2) Añadimos el nombre completo tal cual (sin acentos)
        $keywords[] = $base;

        // 3) Si hay paréntesis (ej. SARS-CoV-2 (COVID-19)), añadimos lo de dentro
        if (Str::contains($base, '(') && Str::contains($base, ')')) {
            $inside = Str::between($base, '(', ')');
            if ($inside) {
                $keywords[] = trim($inside);
            }
        }

        // 4) Añadimos algunas reglas manuales sencillas
        if (Str::contains($base, 'influenza')) {
            $keywords[] = 'influenza';
            $keywords[] = 'flu';
        }
        if (Str::contains($base, 'covid')) {
            $keywords[] = 'covid-19';
            $keywords[] = 'covid 19';
            $keywords[] = 'sars-cov-2';
        }
        if (Str::contains($base, 'dengue')) {
            $keywords[] = 'dengue';
        }
        if (Str::contains($base, 'hepatitis b')) {
            $keywords[] = 'hepatitis b';
        }
        if (Str::contains($base, 'hepatitis c')) {
            $keywords[] = 'hepatitis c';
        }

        // Eliminamos duplicados y vacíos
        return array_values(array_filter(array_unique($keywords)));
    }
}

