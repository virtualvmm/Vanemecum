<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Elimina tablas que no se utilizan en la aplicación:
     * - alarmas, diagnosticos, noticias, contactos, contacto_mensajes
     */
    public function up(): void
    {
        Schema::dropIfExists('alarmas');
        Schema::dropIfExists('diagnosticos');
        Schema::dropIfExists('noticias');
        Schema::dropIfExists('contacto_mensajes');
        Schema::dropIfExists('contactos');
    }

    /**
     * Reverse the migrations.
     * No se revierten: habría que recrear las tablas con sus estructuras originales.
     */
    public function down(): void
    {
        // Opcional: si necesitas revertir, tendrías que ejecutar las migraciones
        // originales de create_diagnosticos, create_alarmas, create_noticias, create_contactos.
    }
};
