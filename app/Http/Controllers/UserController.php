<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * Controlador de Usuários.
 *
 * Acesso restrito ao administrador via AdminMiddleware.
 * O admin pode visualizar todos os usuários e seus conteúdos,
 * bem como excluir contas. Não é possível criar usuários por aqui
 * (o registro é público via AuthController).
 */
class UserController extends Controller
{
    /**
     * Lista todos os usuários com contagem de álbuns e fotos.
     */
    public function index()
    {
        $users = User::withCount(['albums', 'fotos']) // Evita N+1 na tabela
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Exibe o perfil completo de um usuário para o admin.
     * Admin vê todo o conteúdo, incluindo álbuns e fotos privados.
     */
    public function show(User $user)
    {
        $user->load(['albums.fotos', 'fotos']); // Carrega relacionamentos para exibição

        return view('admin.users.show', compact('user'));
    }

    /**
     * Remove permanentemente um usuário e seus dados associados.
     * O admin não pode excluir a si mesmo (verificado na view e pode ser reforçado aqui).
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário excluído com sucesso.');
    }
}
