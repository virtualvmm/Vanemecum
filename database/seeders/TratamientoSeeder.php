<?php

namespace Database\Seeders;

use App\Models\Tratamiento;
use App\Models\TipoTratamiento;
use Illuminate\Database\Seeder;

/**
 * Siembra solo tratamientos reales (medicamentos y medidas terapéuticas reconocidos).
 * No usa factory para evitar datos inventados.
 */
class TratamientoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = TipoTratamiento::orderBy('id')->pluck('id', 'nombre')->all();
        $idAntiviral   = $tipos['Antiviral'] ?? null;
        $idAntibiotico = $tipos['Antibiótico'] ?? null;
        $idAntifungico = $tipos['Antifúngico'] ?? null;
        $idSoporte     = $tipos['Soporte'] ?? null;

        $tratamientosReales = [
            ['nombre' => 'Oseltamivir', 'descripcion' => 'Antiviral para la gripe (influenza). Inhibe la neuraminidasa. Dosis habitual 75 mg cada 12 h, 5 días.', 'tipo_id' => $idAntiviral],
            ['nombre' => 'Aciclovir', 'descripcion' => 'Antiviral para herpes simple y varicela-zóster. Vía oral o intravenosa según gravedad.', 'tipo_id' => $idAntiviral],
            ['nombre' => 'Ribavirina', 'descripcion' => 'Antiviral para virus respiratorio sincitial y hepatitis C (en combinación).', 'tipo_id' => $idAntiviral],
            ['nombre' => 'Valaciclovir', 'descripcion' => 'Antiviral profármaco del aciclovir. Herpes zóster, herpes genital. Mejor biodisponibilidad oral.', 'tipo_id' => $idAntiviral],
            ['nombre' => 'Vacunación antigripal', 'descripcion' => 'Prevención de la gripe. Recomendada anualmente en grupos de riesgo.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Hidratación y reposo', 'descripcion' => 'Medidas de soporte en infecciones leves: reposo, líquidos y control de fiebre.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Vacunación', 'descripcion' => 'Prevención mediante vacunas (triple vírica, hepatitis, COVID-19, etc.) según calendario.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Amoxicilina', 'descripcion' => 'Antibiótico betalactámico. Infecciones respiratorias, otitis, sinusitis. 500 mg/8 h.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Azitromicina', 'descripcion' => 'Antibiótico macrólido. Neumonía atípica, infecciones de vías respiratorias. 500 mg/día 3 días.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Metronidazol', 'descripcion' => 'Antibiótico/antiparasitario. Giardiasis, amebiasis, anaerobios. 500 mg/8 h.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Ciprofloxacino', 'descripcion' => 'Antibiótico fluoroquinolona. Infecciones urinarias, diarrea del viajero, ántrax. 500 mg/12 h.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Vancomicina', 'descripcion' => 'Antibiótico glicopéptido. SARM, Clostridioides difficile (vía oral), infecciones graves por bacterias Gram positivas. Vía intravenosa.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Ceftriaxona', 'descripcion' => 'Cefalosporina de 3ª generación. Meningitis, gonorrea, infecciones graves. 1-2 g/24 h por vía intravenosa.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Clindamicina', 'descripcion' => 'Antibiótico. Anaerobios, toxoplasmosis (con pirimetamina), alternativa en alergia a penicilina.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Tratamiento antituberculoso', 'descripcion' => 'Rifampicina, isoniazida, pirazinamida, etambutol. Pautas de 6 meses según sensibilidad.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Cotrimoxazol', 'descripcion' => 'Sulfametoxazol con trimetoprima. Neumonía por Pneumocystis jirovecii, infecciones urinarias, toxoplasmosis.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Tinidazol', 'descripcion' => 'Antiparasitario/antibiótico. Giardiasis, amebiasis, tricomoniasis. Dosis única o corta pauta.', 'tipo_id' => $idAntibiotico],
            ['nombre' => 'Fluconazol', 'descripcion' => 'Antifúngico triazol. Candidiasis, candidemia, criptococo. 150-400 mg/día según indicación.', 'tipo_id' => $idAntifungico],
            ['nombre' => 'Itraconazol', 'descripcion' => 'Antifúngico para aspergilosis, histoplasmosis, dermatofitosis. Cápsulas o solución oral.', 'tipo_id' => $idAntifungico],
            ['nombre' => 'Anfotericina B', 'descripcion' => 'Antifúngico de amplio espectro. Infecciones fúngicas invasivas graves. Administración por vía intravenosa.', 'tipo_id' => $idAntifungico],
            ['nombre' => 'Cloroquina', 'descripcion' => 'Antipalúdico. Malaria por Plasmodium vivax y P. ovale (con primaquina para hipnozoítos).', 'tipo_id' => $idSoporte],
            ['nombre' => 'Arteméter con lumefantrina', 'descripcion' => 'Combinación antipalúdica para malaria no complicada. Esquema de 3 días.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Primaquina', 'descripcion' => 'Antipalúdico. Eliminación de hipnozoítos en Plasmodium vivax y P. ovale. Requiere descartar deficiencia de G6PD.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Albendazol', 'descripcion' => 'Antihelmíntico. Ascariasis, oxiuriasis, giardiasis, equinococcosis. Dosis única o pauta según parásito.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Ivermectina', 'descripcion' => 'Antihelmíntico y antiparasitario. Escabiosis, estrongiloidiasis, filariasis. Dosis única en muchos casos.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Mebendazol', 'descripcion' => 'Antihelmíntico. Ascariasis, oxiuriasis, tricuriasis. 100 mg/12 h durante 3 días o dosis única.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Praziquantel', 'descripcion' => 'Antiparasitario. Esquistosomiasis, teniasis, opistorquiasis. Dosis única o corta pauta.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Nitazoxanida', 'descripcion' => 'Antiparasitario y antiviral. Giardiasis, criptosporidiosis, rotavirus en niños.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Benznidazol', 'descripcion' => 'Antiparasitario. Enfermedad de Chagas (Trypanosoma cruzi). 5-7,5 mg/kg/día 60 días.', 'tipo_id' => $idSoporte],
            ['nombre' => 'Antimoniales pentavalentes', 'descripcion' => 'Antimoniato de meglumina. Leishmaniosis visceral y cutánea. Esquema según forma clínica.', 'tipo_id' => $idSoporte],
        ];

        foreach ($tratamientosReales as $t) {
            Tratamiento::firstOrCreate(
                ['nombre' => $t['nombre']],
                [
                    'descripcion' => $t['descripcion'],
                    'tipo_id'     => $t['tipo_id'],
                ]
            );
        }
    }
}
