<?php

namespace Database\Seeders;

use App\Models\Patogeno;
use App\Models\Sintoma;
use App\Models\Tratamiento;
use App\Models\TipoPatogeno;
use App\Models\TipoTratamiento;
use Illuminate\Database\Seeder;

/**
 * Añade patógenos realistas (virus, bacterias, hongos, parásitos)
 * con sus tratamientos y síntomas asociados.
 */
class PatogenosCuratedSeeder extends Seeder
{
    public function run(): void
    {
        $tiposPatogeno = TipoPatogeno::orderBy('id')->pluck('id', 'nombre')->all();
        $tiposTratamiento = TipoTratamiento::orderBy('id')->pluck('id', 'nombre')->all();

        $idVirus    = $tiposPatogeno['Virus'] ?? 1;
        $idBacterias = $tiposPatogeno['Bacterias'] ?? 2;
        $idHongos   = $tiposPatogeno['Hongos'] ?? 3;
        $idParasitos = $tiposPatogeno['Parásitos'] ?? 4;

        $idAntiviral   = $tiposTratamiento['Antiviral'] ?? null;
        $idAntibiotico = $tiposTratamiento['Antibiótico'] ?? null;
        $idAntifungico = $tiposTratamiento['Antifúngico'] ?? null;
        $idSoporte     = $tiposTratamiento['Soporte'] ?? null;

        // --- Tratamientos realistas (firstOrCreate por nombre) ---
        $tratamientos = [];
        $tratamientos['Oseltamivir'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Oseltamivir'],
            ['descripcion' => 'Antiviral para la gripe (influenza). Inhibe la neuraminidasa. Dosis habitual 75 mg cada 12 h, 5 días.', 'tipo_id' => $idAntiviral]
        );
        $tratamientos['Aciclovir'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Aciclovir'],
            ['descripcion' => 'Antiviral para herpes simple y varicela-zóster. Vía oral o intravenosa según gravedad.', 'tipo_id' => $idAntiviral]
        );
        $tratamientos['Ribavirina'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Ribavirina'],
            ['descripcion' => 'Antiviral para virus respiratorio sincitial y hepatitis C (en combinación).', 'tipo_id' => $idAntiviral]
        );
        $tratamientos['Vacunación antigripal'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Vacunación antigripal'],
            ['descripcion' => 'Prevención de la gripe. Recomendada anualmente en grupos de riesgo.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Hidratación y reposo'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Hidratación y reposo'],
            ['descripcion' => 'Medidas de soporte en infecciones leves: reposo, líquidos y control de fiebre.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Amoxicilina'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Amoxicilina'],
            ['descripcion' => 'Antibiótico betalactámico. Infecciones respiratorias, otitis, sinusitis. 500 mg/8 h.', 'tipo_id' => $idAntibiotico]
        );
        $tratamientos['Azitromicina'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Azitromicina'],
            ['descripcion' => 'Antibiótico macrólido. Neumonía atípica, infecciones de vías respiratorias. 500 mg/día 3 días.', 'tipo_id' => $idAntibiotico]
        );
        $tratamientos['Metronidazol'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Metronidazol'],
            ['descripcion' => 'Antibiótico/antiparasitario. Giardiasis, amebiasis, anaerobios. 500 mg/8 h.', 'tipo_id' => $idAntibiotico]
        );
        $tratamientos['Fluconazol'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Fluconazol'],
            ['descripcion' => 'Antifúngico triazol. Candidiasis, candidemia, criptococo. 150-400 mg/día según indicación.', 'tipo_id' => $idAntifungico]
        );
        $tratamientos['Itraconazol'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Itraconazol'],
            ['descripcion' => 'Antifúngico para aspergilosis, histoplasmosis, dermatofitosis. Cápsulas o solución oral.', 'tipo_id' => $idAntifungico]
        );
        $tratamientos['Cloroquina'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Cloroquina'],
            ['descripcion' => 'Antipalúdico. Malaria por Plasmodium vivax y P. ovale (con primaquina para hipnozoítos).', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Arteméter con lumefantrina'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Arteméter con lumefantrina'],
            ['descripcion' => 'Combinación antipalúdica para malaria no complicada. Esquema de 3 días.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Albendazol'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Albendazol'],
            ['descripcion' => 'Antihelmíntico. Ascariasis, oxiuriasis, giardiasis, equinococcosis. Dosis única o pauta según parásito.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Ivermectina'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Ivermectina'],
            ['descripcion' => 'Antihelmíntico y antiparasitario. Escabiosis, estrongiloidiasis, filariasis. Dosis única en muchos casos.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Valaciclovir'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Valaciclovir'],
            ['descripcion' => 'Antiviral profármaco del aciclovir. Herpes zóster, herpes genital. Mejor biodisponibilidad oral.', 'tipo_id' => $idAntiviral]
        );
        $tratamientos['Ciprofloxacino'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Ciprofloxacino'],
            ['descripcion' => 'Antibiótico fluoroquinolona. Infecciones urinarias, diarrea del viajero, ántrax. 500 mg/12 h.', 'tipo_id' => $idAntibiotico]
        );
        $tratamientos['Vancomicina'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Vancomicina'],
            ['descripcion' => 'Antibiótico glicopéptido. SARM, Clostridioides difficile (vía oral), infecciones graves por bacterias Gram positivas. Vía intravenosa.', 'tipo_id' => $idAntibiotico]
        );
        $tratamientos['Ceftriaxona'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Ceftriaxona'],
            ['descripcion' => 'Cefalosporina de 3ª generación. Meningitis, gonorrea, infecciones graves. 1-2 g/24 h por vía intravenosa.', 'tipo_id' => $idAntibiotico]
        );
        $tratamientos['Clindamicina'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Clindamicina'],
            ['descripcion' => 'Antibiótico. Anaerobios, toxoplasmosis (con pirimetamina), alternativa en alergia a penicilina.', 'tipo_id' => $idAntibiotico]
        );
        $tratamientos['Anfotericina B'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Anfotericina B'],
            ['descripcion' => 'Antifúngico de amplio espectro. Infecciones fúngicas invasivas graves. Administración por vía intravenosa.', 'tipo_id' => $idAntifungico]
        );
        $tratamientos['Praziquantel'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Praziquantel'],
            ['descripcion' => 'Antiparasitario. Esquistosomiasis, teniasis, opistorquiasis. Dosis única o corta pauta.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Mebendazol'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Mebendazol'],
            ['descripcion' => 'Antihelmíntico. Ascariasis, oxiuriasis, tricuriasis. 100 mg/12 h durante 3 días o dosis única.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Primaquina'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Primaquina'],
            ['descripcion' => 'Antipalúdico. Eliminación de hipnozoítos en Plasmodium vivax y P. ovale. Requiere descartar deficiencia de G6PD.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Vacunación'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Vacunación'],
            ['descripcion' => 'Prevención mediante vacunas (triple vírica, hepatitis, COVID-19, etc.) según calendario.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Tratamiento antituberculoso'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Tratamiento antituberculoso'],
            ['descripcion' => 'Rifampicina, isoniazida, pirazinamida, etambutol. Pautas de 6 meses según sensibilidad.', 'tipo_id' => $idAntibiotico]
        );
        $tratamientos['Cotrimoxazol'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Cotrimoxazol'],
            ['descripcion' => 'Sulfametoxazol con trimetoprima. Neumonía por Pneumocystis jirovecii, infecciones urinarias, toxoplasmosis.', 'tipo_id' => $idAntibiotico]
        );
        $tratamientos['Nitazoxanida'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Nitazoxanida'],
            ['descripcion' => 'Antiparasitario y antiviral. Giardiasis, criptosporidiosis, rotavirus en niños.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Benznidazol'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Benznidazol'],
            ['descripcion' => 'Antiparasitario. Enfermedad de Chagas (Trypanosoma cruzi). 5-7,5 mg/kg/día 60 días.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Antimoniales pentavalentes'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Antimoniales pentavalentes'],
            ['descripcion' => 'Antimoniato de meglumina. Leishmaniosis visceral y cutánea. Esquema según forma clínica.', 'tipo_id' => $idSoporte]
        );
        $tratamientos['Tinidazol'] = Tratamiento::firstOrCreate(
            ['nombre' => 'Tinidazol'],
            ['descripcion' => 'Antiparasitario/antibiótico. Giardiasis, amebiasis, tricomoniasis. Dosis única o corta pauta.', 'tipo_id' => $idAntibiotico]
        );

        // --- Síntomas fijos (firstOrCreate para poder asociarlos) ---
        $sintomas = [];
        foreach (
            [
                ['nombre' => 'Fiebre', 'descripcion' => 'Elevación de la temperatura corporal por encima de 38 °C.', 'gravedad' => 2],
                ['nombre' => 'Tos', 'descripcion' => 'Tos seca o productiva, de intensidad variable.', 'gravedad' => 2],
                ['nombre' => 'Cefalea', 'descripcion' => 'Dolor de cabeza, a veces intenso.', 'gravedad' => 2],
                ['nombre' => 'Dolor muscular', 'descripcion' => 'Mialgia generalizada o localizada.', 'gravedad' => 2],
                ['nombre' => 'Diarrea', 'descripcion' => 'Deposiciones líquidas o frecuentes.', 'gravedad' => 3],
                ['nombre' => 'Náuseas y vómitos', 'descripcion' => 'Malestar digestivo y vómitos.', 'gravedad' => 3],
                ['nombre' => 'Erupción cutánea', 'descripcion' => 'Lesiones en piel de diverso tipo.', 'gravedad' => 2],
                ['nombre' => 'Dolor abdominal', 'descripcion' => 'Dolor en la zona del abdomen.', 'gravedad' => 3],
                ['nombre' => 'Fatiga', 'descripcion' => 'Cansancio y astenia.', 'gravedad' => 2],
                ['nombre' => 'Dolor de garganta', 'descripcion' => 'Odynofagia, enrojecimiento faríngeo.', 'gravedad' => 2],
                ['nombre' => 'Congestión nasal', 'descripcion' => 'Obstrucción o rinorrea.', 'gravedad' => 1],
                ['nombre' => 'Escalofríos', 'descripcion' => 'Tiritona y sensación de frío.', 'gravedad' => 2],
                ['nombre' => 'Ictericia', 'descripcion' => 'Coloración amarillenta de piel y mucosas.', 'gravedad' => 4],
                ['nombre' => 'Prurito', 'descripcion' => 'Picor en piel o zona genital.', 'gravedad' => 2],
            ] as $s
        ) {
            $sintomas[$s['nombre']] = Sintoma::firstOrCreate(
                ['nombre' => $s['nombre']],
                ['descripcion' => $s['descripcion'], 'gravedad' => $s['gravedad']]
            );
        }

        // --- Patógenos: Virus ---
        $virus = [
            [
                'nombre' => 'Virus de la influenza A',
                'descripcion' => 'Virus ARN de la familia Orthomyxoviridae. Causa gripe estacional y pandemias. Transmisión por gotas. Alta mutabilidad.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Oseltamivir', 'Vacunación antigripal', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Tos', 'Cefalea', 'Dolor muscular', 'Fatiga', 'Congestión nasal', 'Dolor de garganta', 'Escalofríos'],
            ],
            [
                'nombre' => 'Rinovirus',
                'descripcion' => 'Principal causa del resfriado común. Más de 100 serotipos. Transmisión por contacto y gotas. Infección leve de vías altas.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Hidratación y reposo'],
                'sintomas' => ['Congestión nasal', 'Dolor de garganta', 'Tos', 'Cefalea', 'Fatiga'],
            ],
            [
                'nombre' => 'Virus herpes simple tipo 1',
                'descripcion' => 'Virus ADN. Infección labial (herpes labial) y en ocasiones genital o encefálica. Latencia en ganglios nerviosos.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Aciclovir', 'Hidratación y reposo'],
                'sintomas' => ['Erupción cutánea', 'Dolor de garganta', 'Fiebre'],
            ],
            [
                'nombre' => 'Virus respiratorio sincitial (VRS)',
                'descripcion' => 'Causa principal de bronquiolitis en lactantes. Infección estacional. En adultos suele ser leve.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Ribavirina', 'Hidratación y reposo'],
                'sintomas' => ['Tos', 'Fiebre', 'Congestión nasal', 'Fatiga'],
            ],
            [
                'nombre' => 'SARS-CoV-2 (COVID-19)',
                'descripcion' => 'Coronavirus. Pandemia COVID-19. Transmisión por gotas y aerosoles. Síndrome respiratorio agudo.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Vacunación', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Tos', 'Cefalea', 'Dolor muscular', 'Fatiga', 'Dolor de garganta', 'Congestión nasal', 'Diarrea'],
            ],
            [
                'nombre' => 'Virus del dengue',
                'descripcion' => 'Flavivirus. Transmitido por mosquito Aedes. Dengue clásico y dengue grave (hemorrágico).',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Cefalea', 'Dolor muscular', 'Dolor abdominal', 'Erupción cutánea', 'Náuseas y vómitos'],
            ],
            [
                'nombre' => 'Virus de la hepatitis B',
                'descripcion' => 'Hepadnavirus. Hepatitis aguda y crónica. Transmisión sanguínea, sexual, vertical. Riesgo de cirrosis y carcinoma hepatocelular.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Vacunación', 'Hidratación y reposo'],
                'sintomas' => ['Fatiga', 'Ictericia', 'Dolor abdominal', 'Náuseas y vómitos', 'Fiebre'],
            ],
            [
                'nombre' => 'Virus de la hepatitis C',
                'descripcion' => 'Flavivirus. Hepatitis aguda y crónica. Transmisión sanguínea. Actualmente curable con antivirales de acción directa.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Hidratación y reposo'],
                'sintomas' => ['Fatiga', 'Ictericia', 'Dolor abdominal', 'Náuseas y vómitos'],
            ],
            [
                'nombre' => 'Virus del Zika',
                'descripcion' => 'Flavivirus. Transmitido por Aedes. Infección leve; en embarazo riesgo de microcefalia fetal.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Erupción cutánea', 'Dolor muscular', 'Cefalea', 'Prurito'],
            ],
            [
                'nombre' => 'Virus de la varicela-zóster',
                'descripcion' => 'Herpesvirus. Varicela (primoinfección) y herpes zóster (reactivación). Muy contagioso.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Aciclovir', 'Valaciclovir', 'Vacunación', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Erupción cutánea', 'Prurito', 'Cefalea', 'Fatiga'],
            ],
            [
                'nombre' => 'Virus del sarampión',
                'descripcion' => 'Paramixovirus. Enfermedad muy contagiosa. Manchas de Koplik, exantema. Prevención con vacuna triple vírica.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Vacunación', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Tos', 'Erupción cutánea', 'Congestión nasal', 'Dolor de garganta', 'Cefalea'],
            ],
            [
                'nombre' => 'Norovirus',
                'descripcion' => 'Principal causa de gastroenteritis aguda por virus. Brotes en comunidades y cruceros. Muy contagioso.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Hidratación y reposo'],
                'sintomas' => ['Diarrea', 'Náuseas y vómitos', 'Dolor abdominal', 'Fiebre'],
            ],
            [
                'nombre' => 'Rotavirus',
                'descripcion' => 'Causa principal de diarrea grave en lactantes y niños. Vacuna incluida en calendario infantil.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Vacunación', 'Hidratación y reposo', 'Nitazoxanida'],
                'sintomas' => ['Diarrea', 'Náuseas y vómitos', 'Fiebre', 'Dolor abdominal'],
            ],
            [
                'nombre' => 'Adenovirus',
                'descripcion' => 'Virus ADN. Infecciones respiratorias, conjuntivitis, gastroenteritis. Múltiples serotipos.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Tos', 'Dolor de garganta', 'Congestión nasal', 'Diarrea'],
            ],
            [
                'nombre' => 'Virus de la parotiditis',
                'descripcion' => 'Paramixovirus. Paperas: inflamación de glándulas salivales. Prevención con vacuna triple vírica.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Vacunación', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Cefalea', 'Fatiga', 'Dolor muscular'],
            ],
            [
                'nombre' => 'Virus de la rabia',
                'descripcion' => 'Lyssavirus. Encefalitis casi siempre mortal. Transmisión por mordedura de animal infectado. Prevención con vacuna y inmunoglobulina.',
                'tipo_patogeno_id' => $idVirus,
                'tratamientos' => ['Vacunación', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Cefalea', 'Fatiga', 'Dolor muscular', 'Náuseas y vómitos'],
            ],
        ];

        // --- Patógenos: Bacterias ---
        $bacterias = [
            [
                'nombre' => 'Streptococcus pyogenes',
                'descripcion' => 'Bacteria Gram positiva. Faringitis estreptocócica, escarlatina, impétigo. Complicaciones: fiebre reumática, glomerulonefritis.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Amoxicilina', 'Hidratación y reposo'],
                'sintomas' => ['Dolor de garganta', 'Fiebre', 'Cefalea', 'Erupción cutánea', 'Fatiga'],
            ],
            [
                'nombre' => 'Escherichia coli',
                'descripcion' => 'Bacteria Gram negativa. Infecciones urinarias, gastroenteritis, sepsis. Cepas productoras de toxina Shiga (EHEC) causan diarrea sanguinolenta.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Amoxicilina', 'Azitromicina', 'Hidratación y reposo'],
                'sintomas' => ['Diarrea', 'Dolor abdominal', 'Náuseas y vómitos', 'Fiebre'],
            ],
            [
                'nombre' => 'Salmonella enterica',
                'descripcion' => 'Bacteria Gram negativa. Salmonelosis (gastroenteritis y fiebre tifoidea). Transmisión por alimentos y agua contaminados.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Azitromicina', 'Hidratación y reposo'],
                'sintomas' => ['Diarrea', 'Dolor abdominal', 'Fiebre', 'Náuseas y vómitos', 'Cefalea'],
            ],
            [
                'nombre' => 'Mycoplasma pneumoniae',
                'descripcion' => 'Bacteria atípica sin pared. Neumonía atípica y bronquitis. Común en niños y adultos jóvenes.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Azitromicina', 'Hidratación y reposo'],
                'sintomas' => ['Tos', 'Fiebre', 'Cefalea', 'Dolor muscular', 'Fatiga'],
            ],
            [
                'nombre' => 'Staphylococcus aureus',
                'descripcion' => 'Bacteria Gram positiva. Infecciones de piel, abscesos, neumonía, sepsis. MRSA resistente a meticilina.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Amoxicilina', 'Vancomicina', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Erupción cutánea', 'Dolor muscular', 'Fatiga'],
            ],
            [
                'nombre' => 'Clostridium difficile',
                'descripcion' => 'Bacteria anaerobia. Colitis asociada a antibióticos. Diarrea acuosa o seudomembranosa.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Vancomicina', 'Metronidazol', 'Hidratación y reposo'],
                'sintomas' => ['Diarrea', 'Dolor abdominal', 'Fiebre', 'Náuseas y vómitos'],
            ],
            [
                'nombre' => 'Neisseria meningitidis',
                'descripcion' => 'Bacteria Gram negativa. Meningitis meningocócica y sepsis. Transmisión por gotas. Enfermedad invasiva grave.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Ceftriaxona', 'Vacunación', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Cefalea', 'Náuseas y vómitos', 'Erupción cutánea', 'Dolor muscular'],
            ],
            [
                'nombre' => 'Haemophilus influenzae',
                'descripcion' => 'Bacteria Gram negativa. Otitis, sinusitis, neumonía, meningitis (tipo b). Prevención con vacuna Hib.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Amoxicilina', 'Ceftriaxona', 'Vacunación', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Tos', 'Dolor de garganta', 'Congestión nasal', 'Cefalea'],
            ],
            [
                'nombre' => 'Pseudomonas aeruginosa',
                'descripcion' => 'Bacteria Gram negativa oportunista. Infecciones nosocomiales, neumonía, sepsis, otitis del nadador.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Ciprofloxacino', 'Ceftriaxona', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Tos', 'Fatiga', 'Dolor muscular'],
            ],
            [
                'nombre' => 'Mycobacterium tuberculosis',
                'descripcion' => 'Bacilo ácido-alcohol resistente. Tuberculosis pulmonar y extrapulmonar. Transmisión por gotas.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Tratamiento antituberculoso', 'Hidratación y reposo'],
                'sintomas' => ['Tos', 'Fiebre', 'Fatiga', 'Cefalea', 'Dolor muscular'],
            ],
            [
                'nombre' => 'Helicobacter pylori',
                'descripcion' => 'Bacteria Gram negativa. Gastritis, úlcera péptica, riesgo de cáncer gástrico. Transmisión fecal-oral.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Amoxicilina', 'Metronidazol', 'Hidratación y reposo'],
                'sintomas' => ['Dolor abdominal', 'Náuseas y vómitos', 'Fatiga'],
            ],
            [
                'nombre' => 'Vibrio cholerae',
                'descripcion' => 'Bacteria Gram negativa. Cólera: diarrea acuosa masiva, deshidratación. Transmisión por agua y alimentos contaminados.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Azitromicina', 'Ciprofloxacino', 'Hidratación y reposo'],
                'sintomas' => ['Diarrea', 'Dolor abdominal', 'Náuseas y vómitos', 'Fatiga'],
            ],
            [
                'nombre' => 'Clostridium tetani',
                'descripcion' => 'Bacteria anaerobia. Tétanos: espasmos musculares, trismo. Entrada por heridas. Prevención con vacuna.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Vacunación', 'Metronidazol', 'Hidratación y reposo'],
                'sintomas' => ['Dolor muscular', 'Cefalea', 'Fiebre'],
            ],
            [
                'nombre' => 'Bordetella pertussis',
                'descripcion' => 'Bacteria Gram negativa. Tos ferina (pertussis). Tos paroxística. Prevención con vacuna DTPa.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Azitromicina', 'Vacunación', 'Hidratación y reposo'],
                'sintomas' => ['Tos', 'Congestión nasal', 'Fiebre', 'Fatiga'],
            ],
            [
                'nombre' => 'Neisseria gonorrhoeae',
                'descripcion' => 'Bacteria Gram negativa. Gonococia: infección de transmisión sexual. Uretritis, cervicitis, faringitis.',
                'tipo_patogeno_id' => $idBacterias,
                'tratamientos' => ['Ceftriaxona', 'Azitromicina', 'Hidratación y reposo'],
                'sintomas' => ['Dolor de garganta', 'Prurito', 'Dolor abdominal'],
            ],
        ];

        // --- Patógenos: Hongos ---
        $hongos = [
            [
                'nombre' => 'Candida albicans',
                'descripcion' => 'Levadura oportunista. Candidiasis oral, vaginal, invasiva (candidemia). Común en inmunodeprimidos y tras antibióticos.',
                'tipo_patogeno_id' => $idHongos,
                'tratamientos' => ['Fluconazol', 'Hidratación y reposo'],
                'sintomas' => ['Prurito', 'Erupción cutánea', 'Dolor abdominal'],
            ],
            [
                'nombre' => 'Aspergillus fumigatus',
                'descripcion' => 'Moho ambiental. Aspergilosis broncopulmonar alérgica, aspergiloma, aspergilosis invasiva en inmunodeprimidos.',
                'tipo_patogeno_id' => $idHongos,
                'tratamientos' => ['Itraconazol', 'Hidratación y reposo'],
                'sintomas' => ['Tos', 'Fiebre', 'Fatiga', 'Dolor muscular'],
            ],
            [
                'nombre' => 'Dermatofitos (Trichophyton, Microsporum)',
                'descripcion' => 'Hongos queratinófilos. Tiña del pie, uñas, cuerpo y cuero cabelludo. Contagio por contacto directo o fómites.',
                'tipo_patogeno_id' => $idHongos,
                'tratamientos' => ['Itraconazol', 'Fluconazol', 'Hidratación y reposo'],
                'sintomas' => ['Erupción cutánea', 'Prurito'],
            ],
            [
                'nombre' => 'Cryptococcus neoformans',
                'descripcion' => 'Levadura encapsulada. Meningoencefalitis y neumonía en inmunodeprimidos (VIH). Transmisión por inhalación.',
                'tipo_patogeno_id' => $idHongos,
                'tratamientos' => ['Fluconazol', 'Anfotericina B', 'Hidratación y reposo'],
                'sintomas' => ['Cefalea', 'Fiebre', 'Fatiga', 'Náuseas y vómitos'],
            ],
            [
                'nombre' => 'Pneumocystis jirovecii',
                'descripcion' => 'Hongo oportunista. Neumonía por Pneumocystis (PCP) en pacientes con VIH o inmunodepresión.',
                'tipo_patogeno_id' => $idHongos,
                'tratamientos' => ['Cotrimoxazol', 'Hidratación y reposo'],
                'sintomas' => ['Tos', 'Fiebre', 'Fatiga', 'Dolor muscular'],
            ],
            [
                'nombre' => 'Histoplasma capsulatum',
                'descripcion' => 'Hongo dimórfico. Histoplasmosis: infección pulmonar y diseminada. Común en zonas con suelo rico en excrementos de aves.',
                'tipo_patogeno_id' => $idHongos,
                'tratamientos' => ['Itraconazol', 'Anfotericina B', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Tos', 'Fatiga', 'Dolor muscular', 'Cefalea'],
            ],
            [
                'nombre' => 'Coccidioides immitis',
                'descripcion' => 'Hongo dimórfico. Fiebre del Valle (coccidioidomicosis). Endémico en suelos áridos de América.',
                'tipo_patogeno_id' => $idHongos,
                'tratamientos' => ['Fluconazol', 'Itraconazol', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Tos', 'Cefalea', 'Erupción cutánea', 'Fatiga'],
            ],
        ];

        // --- Patógenos: Parásitos ---
        $parasitos = [
            [
                'nombre' => 'Plasmodium falciparum',
                'descripcion' => 'Protozoo. Malaria (paludismo) tropical. Transmisión por mosquito Anopheles. Forma grave: malaria cerebral, anemia hemolítica.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Arteméter con lumefantrina', 'Cloroquina', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Escalofríos', 'Cefalea', 'Dolor muscular', 'Fatiga', 'Ictericia', 'Diarrea'],
            ],
            [
                'nombre' => 'Giardia lamblia',
                'descripcion' => 'Protozoo flagelado. Giardiasis: diarrea crónica, esteatorrea, malabsorción. Transmisión por agua y alimentos contaminados.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Metronidazol', 'Albendazol', 'Hidratación y reposo'],
                'sintomas' => ['Diarrea', 'Dolor abdominal', 'Náuseas y vómitos', 'Fatiga'],
            ],
            [
                'nombre' => 'Ascaris lumbricoides',
                'descripcion' => 'Nematodo. Ascariasis: infección intestinal muy prevalente en zonas tropicales. Transmisión fecal-oral.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Albendazol', 'Ivermectina', 'Hidratación y reposo'],
                'sintomas' => ['Dolor abdominal', 'Diarrea', 'Náuseas y vómitos', 'Tos'],
            ],
            [
                'nombre' => 'Enterobius vermicularis',
                'descripcion' => 'Oxiuro. Infección muy frecuente en niños. Prurito anal nocturno. Transmisión por huevos en manos y fómites.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Albendazol', 'Ivermectina', 'Hidratación y reposo'],
                'sintomas' => ['Prurito', 'Dolor abdominal', 'Fatiga'],
            ],
            [
                'nombre' => 'Sarcoptes scabiei',
                'descripcion' => 'Ácaro. Escabiosis (sarna). Túneles en piel, prurito intenso. Contagio por contacto piel con piel.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Ivermectina', 'Hidratación y reposo'],
                'sintomas' => ['Prurito', 'Erupción cutánea'],
            ],
            [
                'nombre' => 'Toxoplasma gondii',
                'descripcion' => 'Protozoo. Toxoplasmosis. Infección leve en inmunocompetentes; grave en embarazo (riesgo fetal) e inmunodeprimidos.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Clindamicina', 'Cotrimoxazol', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Cefalea', 'Fatiga', 'Dolor muscular'],
            ],
            [
                'nombre' => 'Entamoeba histolytica',
                'descripcion' => 'Protozoo. Amebiasis: disentería amebiana, absceso hepático. Transmisión fecal-oral.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Metronidazol', 'Tinidazol', 'Hidratación y reposo'],
                'sintomas' => ['Diarrea', 'Dolor abdominal', 'Náuseas y vómitos', 'Fiebre'],
            ],
            [
                'nombre' => 'Trypanosoma cruzi',
                'descripcion' => 'Protozoo. Enfermedad de Chagas. Transmitido por vinchuca. Cardiopatía y megacolon en fase crónica.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Benznidazol', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Fatiga', 'Dolor abdominal', 'Cefalea', 'Erupción cutánea'],
            ],
            [
                'nombre' => 'Leishmania',
                'descripcion' => 'Protozoo. Leishmaniosis cutánea, mucosa y visceral. Transmitido por flebótomos.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Antimoniales pentavalentes', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Erupción cutánea', 'Fatiga', 'Dolor abdominal'],
            ],
            [
                'nombre' => 'Trichomonas vaginalis',
                'descripcion' => 'Protozoo flagelado. Tricomoniasis: infección de transmisión sexual. Vaginitis y uretritis.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Metronidazol', 'Tinidazol', 'Hidratación y reposo'],
                'sintomas' => ['Prurito', 'Dolor abdominal'],
            ],
            [
                'nombre' => 'Taenia solium',
                'descripcion' => 'Cestodo. Teniasis intestinal y cisticercosis (forma larvaria en SNC). Transmisión por carne de cerdo.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Praziquantel', 'Albendazol', 'Hidratación y reposo'],
                'sintomas' => ['Dolor abdominal', 'Diarrea', 'Náuseas y vómitos', 'Cefalea'],
            ],
            [
                'nombre' => 'Strongyloides stercoralis',
                'descripcion' => 'Nematodo. Estrongiloidiasis. Hiperinfección en inmunodeprimidos. Transmisión por penetración cutánea de larvas.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Ivermectina', 'Albendazol', 'Hidratación y reposo'],
                'sintomas' => ['Dolor abdominal', 'Diarrea', 'Erupción cutánea', 'Prurito', 'Tos'],
            ],
            [
                'nombre' => 'Plasmodium vivax',
                'descripcion' => 'Protozoo. Malaria por P. vivax. Forma recurrente por hipnozoítos en hígado. Tratamiento con primaquina para radical curación.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Cloroquina', 'Primaquina', 'Arteméter con lumefantrina', 'Hidratación y reposo'],
                'sintomas' => ['Fiebre', 'Escalofríos', 'Cefalea', 'Dolor muscular', 'Fatiga', 'Diarrea'],
            ],
            [
                'nombre' => 'Ancylostoma duodenale',
                'descripcion' => 'Nematodo. Anquilostomiasis. Anemia por pérdida de sangre intestinal. Penetración cutánea de larvas.',
                'tipo_patogeno_id' => $idParasitos,
                'tratamientos' => ['Albendazol', 'Mebendazol', 'Hidratación y reposo'],
                'sintomas' => ['Dolor abdominal', 'Fatiga', 'Diarrea', 'Erupción cutánea', 'Prurito'],
            ],
        ];

        $todos = array_merge($virus, $bacterias, $hongos, $parasitos);

        foreach ($todos as $p) {
            $tratamientosNombres = $p['tratamientos'];
            $sintomasNombres = $p['sintomas'];
            unset($p['tratamientos'], $p['sintomas']);

            $patogeno = Patogeno::updateOrCreate(
                ['nombre' => $p['nombre']],
                array_merge($p, ['is_active' => true])
            );

            $idsTratamientos = collect($tratamientosNombres)->map(function ($nombre) use ($tratamientos) {
                return $tratamientos[$nombre]->id ?? null;
            })->filter()->values()->all();

            $idsSintomas = collect($sintomasNombres)->map(function ($nombre) use ($sintomas) {
                return $sintomas[$nombre]->id ?? null;
            })->filter()->values()->all();

            if (!empty($idsTratamientos)) {
                $patogeno->tratamientos()->syncWithoutDetaching($idsTratamientos);
            }
            if (!empty($idsSintomas)) {
                $patogeno->sintomas()->syncWithoutDetaching($idsSintomas);
            }
        }

        $this->command->info('Patógenos y tratamientos curados creados/actualizados.');
    }
}
