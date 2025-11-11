<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patogeno_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patogeno_id');
            $table->string('path', 255);
            $table->string('caption', 255)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->foreign('patogeno_id')->references('id')->on('patogenos')->onDelete('cascade');
            $table->index(['patogeno_id', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patogeno_images');
    }
};


