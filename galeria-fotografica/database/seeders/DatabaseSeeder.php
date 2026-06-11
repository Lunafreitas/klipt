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
        // ── Usuário Administrador ──────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Administrador',
            'email'    => 'admin@klipt.test',
            'password' => Hash::make('password'),
            'is_admin' => true, // Acesso total: usuários, tags e todo conteúdo
        ]);

        // ── Usuário Comum ─────────────────────────────────────────────────
        $usuario = User::create([
            'name'     => 'João Fotógrafo',
            'email'    => 'usuario@klipt.test',
            'password' => Hash::make('password'),
            'is_admin' => false, // Gerencia apenas seus próprios álbuns e fotos
        ]);

        // ── Tags globais (criadas pelo admin) ─────────────────────────────
        $tags = collect(['Urbano', 'Natureza', 'Retrato', 'Arquitetura', 'Abstrato'])
            ->map(fn ($nome) => Tag::create(['nome' => $nome]));

        // ── Álbum de exemplo para o usuário comum ─────────────────────────
        Album::create([
            'user_id'  => $usuario->id,
            'nome'     => 'Primeiro Álbum',
            'descricao'=> 'Álbum de demonstração criado pelo seeder.',
            'publico'  => true,
        ]);

        $this->command->info('✓ Banco populado com sucesso!');
        $this->command->info('  Admin:   admin@klipt.test / password');
        $this->command->info('  Usuário: usuario@klipt.test / password');
    }
}
