<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Album;
use App\Models\Foto;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder principal — popula o banco com dados de desenvolvimento.
 *
 * Cria:
 *   - 1 usuário administrador (is_admin = 1)
 *   - 1 usuário comum de demonstração
 *   - Tags de exemplo para categorização
 *   - Álbuns e estrutura básica para teste
 *
 * Executar com: php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário Administrador
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@klipt.com.br',
            'password' => Hash::make('password'),
            'is_admin' => true, // Acesso total: usuários, tags e todo conteúdo
        ]);

        // Tags globais (criadas pelo admin)
        $tags = collect(['Urbano', 'Natureza', 'Retrato', 'Arquitetura', 'Abstrato'])
            ->map(fn ($nome) => Tag::create(['nome' => $nome]));
    }
}
