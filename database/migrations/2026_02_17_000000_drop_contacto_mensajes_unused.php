<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Elimina la tabla contacto_mensajes: duplicada y sin uso.
     * La aplicación usa contact_messages (modelo ContactMessage).
     */
    public function up(): void
    {
        Schema::dropIfExists('contacto_mensajes');
    }

    public function down(): void
    {
        // No se revierte: la tabla era redundante.
    }
};
