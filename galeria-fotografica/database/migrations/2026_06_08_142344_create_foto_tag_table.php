<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration da tabela pivot foto_tag.
 * Relacionamento many-to-many entre Foto e Tag.
 * Nome da tabela segue a convenção do Laravel: modelo_modelo em ordem alfabética.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_tag', function (Blueprint $table) {
            $table->id();
            // Cria a coluna foto_id e conecta com a tabela fotos
            $table->foreignId('foto_id')->constrained('fotos')->onDelete('cascade');
            // Cria a coluna tag_id e conecta com a tabela tags
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('foto_tag');
    }
};
