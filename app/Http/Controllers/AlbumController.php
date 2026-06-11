<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador de Álbuns.
 *
 * Usuário comum: gerencia apenas seus próprios álbuns.
 * A autorização de propriedade é verificada via método privado authorizeAlbumOwner().
 * A validação dos dados é delegada aos FormRequests correspondentes.
 */
class AlbumController extends Controller
{
    /**
     * Lista os álbuns do usuário autenticado com contagem de fotos.
     */
    public function index()
    {
        $albums = Album::where('user_id', Auth::id())
            ->withCount('fotos') // Evita N+1 ao exibir contagem de fotos nos cards
            ->latest()
            ->paginate(12);

        return view('albums.index', compact('albums'));
    }

    /**
     * Exibe o formulário de criação de álbum.
     */
    public function create()
    {
        return view('albums.create');
    }

    /**
     * Persiste um novo álbum vinculado ao usuário autenticado.
     * O user_id é definido no controller (não pelo formulário) por segurança.
     */
    public function store(StoreAlbumRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id(); // Garante que o dono é sempre o usuário logado

        Album::create($validated);

        return redirect()->route('albums.index')
            ->with('success', 'Álbum criado com sucesso.');
    }

    /**
     * Exibe o álbum com todas as suas fotos (públicas e privadas para o dono).
     */
    public function show(Album $album)
    {
        $this->authorizeAlbumOwner($album);

        $album->load(['fotos.tags']); // Eager loading para evitar queries extras

        return view('albums.show', compact('album'));
    }

    /**
     * Exibe o formulário de edição do álbum.
     */
    public function edit(Album $album)
    {
        $this->authorizeAlbumOwner($album);

        return view('albums.edit', compact('album'));
    }

    /**
     * Atualiza os dados do álbum após validação e verificação de propriedade.
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        $this->authorizeAlbumOwner($album);

        $album->update($request->validated());

        return redirect()->route('albums.index')
            ->with('success', 'Álbum atualizado com sucesso.');
    }

    /**
     * Remove o álbum do banco de dados.
     * As fotos vinculadas são mantidas (sem cascade delete nos models).
     */
    public function destroy(Album $album)
    {
        $this->authorizeAlbumOwner($album);

        $album->delete();

        return redirect()->route('albums.index')
            ->with('success', 'Álbum excluído com sucesso.');
    }

    /**
     * Verifica se o álbum pertence ao usuário autenticado.
     * Retorna HTTP 403 caso contrário.
     *
     * @param  Album  $album
     * @return void
     */
    private function authorizeAlbumOwner(Album $album): void
    {
        abort_unless($album->user_id === Auth::id(), 403, 'Acesso negado.');
    }
}
