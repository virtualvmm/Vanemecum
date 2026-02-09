<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacto_mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('email', 255);
            $table->string('asunto', 255);
            $table->text('mensaje');
            $table->boolean('leido')->default(false);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->index('leido');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacto_mensajes');
    }
};

