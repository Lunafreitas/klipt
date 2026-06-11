<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class PublicGalleryController extends Controller
{
    /**
     * Galeria principal — lista fotos públicas em ordem decrescente.
     * Carrega relacionamentos para evitar N+1 queries.
     */
    public function index()
    {
        $fotos = Foto::with(['user', 'album', 'tags'])
            ->where('publico', true) // Exibe apenas fotos marcadas como públicas
            ->latest()
            ->paginate(20);

        return view('public.index', compact('fotos'));
    }

    /**
     * Detalhe de uma foto pública.
     * Redireciona com 403 se a foto for privada.
     */
    public function foto(Foto $foto)
    {
        // Garante que apenas fotos públicas sejam acessíveis por visitantes
        abort_unless($foto->publico, 403, 'Esta foto é privada.');

        $foto->load('user', 'album', 'tags');
    }

    /**
     * Álbum público — exibe fotos públicas do álbum.
     * Retorna 403 se o álbum estiver marcado como privado.
     */
    public function album(Album $album)
    {
        // Apenas álbuns públicos são acessíveis sem autenticação
        abort_if(! $album->publico, 403, 'Este álbum é privado.');

        $album->load(['user', 'fotos' => function ($query) {
            // Carrega apenas as fotos públicas do álbum
            $query->where('publico', true)->with('tags');
        }]);

        return view('public.album', compact('album'));
    }

    /**
     * Perfil público de um fotógrafo.
     * Exibe apenas álbuns e fotos públicos do usuário.
     */
    public function fotografo(User $user)
    {
        // Carrega álbuns públicos com contagem de fotos públicas
        $user->load([
            'albums' => function ($query) {
                $query->where('publico', true);
            },
            'fotos' => function ($query) {
                $query->where('publico', true)->latest()->take(30);
            },
        ]);

        return view('public.fotografo', compact('user'));
    }

    /**
     * Fotos de uma tag específica — apenas fotos públicas.
     */
    public function tag(Tag $tag)
    {
        // Carrega apenas fotos públicas vinculadas à tag com seus autores
        $tag->load(['fotos' => function ($query) {
            $query->where('publico', true)->with('user', 'album');
        }]);

        return view('public.tag', compact('tag'));
    }
}
