<?php

namespace App\Console\Commands;

use App\Models\Patogeno;
use Illuminate\Console\Command;

class EliminarPatogenosInventados extends Command
{
    protected $signature = 'patogenos:eliminar-inventados';
    protected $description = 'Elimina patógenos inventados por el factory y deja solo los reales (virus, bacterias, hongos, parásitos del seeder curado).';

    /** Nombres de los patógenos reales (PatogenosCuratedSeeder). */
    protected array $reales = [
        'Virus de la influenza A',
        'Rinovirus',
        'Virus herpes simple tipo 1',
        'Virus respiratorio sincitial (VRS)',
        'SARS-CoV-2 (COVID-19)',
        'Virus del dengue',
        'Virus de la hepatitis B',
        'Virus de la hepatitis C',
        'Virus del Zika',
        'Virus de la varicela-zóster',
        'Virus del sarampión',
        'Norovirus',
        'Rotavirus',
        'Adenovirus',
        'Virus de la parotiditis',
        'Virus de la rabia',
        'Streptococcus pyogenes',
        'Escherichia coli',
        'Salmonella enterica',
        'Mycoplasma pneumoniae',
        'Staphylococcus aureus',
        'Clostridium difficile',
        'Neisseria meningitidis',
        'Haemophilus influenzae',
        'Pseudomonas aeruginosa',
        'Mycobacterium tuberculosis',
        'Helicobacter pylori',
        'Vibrio cholerae',
        'Clostridium tetani',
        'Bordetella pertussis',
        'Neisseria gonorrhoeae',
        'Candida albicans',
        'Aspergillus fumigatus',
        'Dermatofitos (Trichophyton, Microsporum)',
        'Cryptococcus neoformans',
        'Pneumocystis jirovecii',
        'Histoplasma capsulatum',
        'Coccidioides immitis',
        'Plasmodium falciparum',
        'Giardia lamblia',
        'Ascaris lumbricoides',
        'Enterobius vermicularis',
        'Sarcoptes scabiei',
        'Toxoplasma gondii',
        'Entamoeba histolytica',
        'Trypanosoma cruzi',
        'Leishmania',
        'Trichomonas vaginalis',
        'Taenia solium',
        'Strongyloides stercoralis',
        'Plasmodium vivax',
        'Ancylostoma duodenale',
    ];

    public function handle(): int
    {
        $eliminados = Patogeno::whereNotIn('nombre', $this->reales)->get();

        if ($eliminados->isEmpty()) {
            $this->info('No hay patógenos inventados. Solo existen los reales.');
            return self::SUCCESS;
        }

        $count = $eliminados->count();
        foreach ($eliminados as $p) {
            $p->sintomas()->detach();
            $p->tratamientos()->detach();
            $p->delete();
            $this->line("Eliminado: {$p->nombre}");
        }

        $this->info("Se eliminaron {$count} patógeno(s) inventados. Quedan solo los reales.");
        return self::SUCCESS;
    }
}
