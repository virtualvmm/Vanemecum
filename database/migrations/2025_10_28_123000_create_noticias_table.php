<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla 'noticias', asociada al modelo Noticia.
 */
class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();

            // Clave foránea al usuario que creó la noticia (Autor)
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->comment('ID del usuario autor de la noticia/alerta.');

            // Campos de contenido
            $table->string('titulo', 255)->comment('Título de la noticia.');
            $table->text('cuerpo')->comment('Contenido completo de la noticia.');

            // Categoría y Estado (usando enums para tipificar datos)
            $table->enum('categoria', ['Alerta', 'Noticia', 'Publicación', 'Evento'])
                ->default('Noticia')
                ->comment('Clasificación temática.');
                
            $table->enum('estado', ['Borrador', 'Publicado', 'Archivado'])
                ->default('Borrador')
                ->comment('Estado de visibilidad.');

            // Fecha de publicación
            $table->dateTime('fecha_publicacion')->nullable()->comment('Fecha y hora de publicación.');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noticias');
    }
}
