<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bienvenido') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 mb-3">
                        ¿Qué es Vanemecum?
                    </h3>
                    <p class="mb-4 leading-relaxed">
                        <strong>Vanemecum</strong> es una aplicación de consulta rápida sobre patógenos (virus, bacterias, hongos y parásitos) y sus tratamientos. Funciona como un vademécum de referencia para profesionales y estudiantes del ámbito sanitario, permitiendo localizar información de forma ágil sobre agentes infecciosos, síntomas asociados y opciones terapéuticas.
                    </p>
                    <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 mb-3 mt-6">
                        ¿Para qué sirve?
                    </h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li><strong>Guía Rápida:</strong> consultar patógenos por categoría (Virus, Bacterias, Hongos, Parásitos) y ver fichas con descripción, síntomas y tratamientos.</li>
                        <li><strong>Catálogo:</strong> buscar y filtrar patógenos por nombre o tipo para una visión general.</li>
                        <li><strong>Tratamientos:</strong> listado de tratamientos con su tipo (antiviral, antibiótico, antifúngico, soporte) y descripción.</li>
                        <li><strong>Mis patógenos:</strong> guardar tus patógenos favoritos para acceder a ellos con rapidez.</li>
                        <li><strong>Alertas:</strong> visualización de patógenos en alerta por aumento de casos (sincronizado con la OMS cuando está activo).</li>
                        <li><strong>Contactar:</strong> enviar al administrador sugerencias, reportar errores o proponer nuevos patógenos.</li>
                    </ul>
                    <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">
                        Use el menú superior para navegar por la Guía Rápida, el Catálogo, Tratamientos o Mis patógenos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
