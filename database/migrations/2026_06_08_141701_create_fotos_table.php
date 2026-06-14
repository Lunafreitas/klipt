<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


//  --Migration da tabela de fotos.
//  -- Uma foto pertence a um usuário e a um álbum.
//  -- O campo 'imagem' armazena o caminho relativo ao disco 'public'.

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fotos', function (Blueprint $table) {
            $table->id();
            // Cascade delete: ao excluir o usuário, as fotos também são removidas
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('album_id')->nullable()->constrained('albums')->nullOnDelete();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('imagem');
            $table->boolean('publico')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fotos');
    }
};
