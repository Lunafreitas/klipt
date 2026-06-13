<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFotoRequest;
use App\Http\Requests\UpdateFotoRequest;
use App\Models\Album;
use App\Models\Foto;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
public function download($filename)
{
    $caminhoNoStorage = urldecode($filename); // Decodifica o nome do arquivo
    
    // Verifica se o arquivo existe dentro do disco público
    if (Storage::disk('public')->exists($caminhoNoStorage)) {
        
        // Limpa a memória para o arquivo não vir quebrado
        if (ob_get_level()) { 
            ob_end_clean(); 
        }

        // Pega o caminho físico completo no computador/servidor
        $caminhoAbsoluto = Storage::disk('public')->path($caminhoNoStorage);
        
        // Faz o download usando a resposta padrão do Laravel
        return response()->download($caminhoAbsoluto);
    }

    // Se o arquivo não existir de verdade, mostra o erro na tela
    abort(404, "Arquivo não encontrado no storage público: " . $caminhoNoStorage);
}


    /** Lista as fotos do usuário autenticado com seus relacionamentos. Apenas fotos do próprio usuário são retornadas (filtro por user_id). */
    public function index()
    {
        $fotos = Foto::with(['album', 'tags'])
            ->where('user_id', Auth::id()) // Restringe ao dono das fotos
            ->latest()
            ->get();

        return view('fotos.index', compact('fotos'));
    }

    /**
     * Exibe formulário de upload de foto.
     * Passa apenas os álbuns do usuário autenticado (não pode vincular a álbum alheio).
     */
    public function create()
    {
        $albums = Album::where('user_id', Auth::id())->orderBy('nome')->get();
        $tags   = Tag::orderBy('nome')->get(); // Tags são globais, gerenciadas pelo admin

        return view('fotos.create', compact('albums', 'tags'));
    }

    /**
     * Persiste a foto no banco e no disco.
     * O user_id é definido no controller, nunca via input do formulário.
     * As tags são sincronizadas via tabela pivot foto_tag.
     */
    public function store(StoreFotoRequest $request)
    {
        $validated = $request->validated();

        // Define o dono como o usuário autenticado
        $validated['user_id'] = Auth::id();

        // Armazena a imagem no disco público sob /storage/fotos/
        $validated['imagem'] = $request->file('imagem')->store('fotos', 'public');

        $foto = Foto::create([
            'user_id'   => $validated['user_id'],
            'album_id'  => $validated['album_id'],
            'titulo'    => $validated['titulo'],
            'descricao' => $validated['descricao'] ?? null,
            'imagem'    => $validated['imagem'],
            'publico'   => $validated['publico'],
        ]);

        // Vincula tags selecionadas via tabela pivot (sem tags = sem attach)
        if (! empty($validated['tags'])) {
            $foto->tags()->attach($validated['tags']);
        }

        return redirect()->route('fotos.index')
            ->with('success', 'Foto enviada com sucesso.');
    }

    /**
     * Exibe o detalhe de uma foto para o seu dono.
     * Retorna 403 se o usuário não for o dono da foto.
     */
    public function show(Foto $foto)
    {
        // Apenas o dono pode acessar o detalhe autenticado
        abort_unless($foto->user_id === Auth::id(), 403);

        $foto->load('album', 'tags');

        return view('fotos.show', compact('foto'));
    }

    /**
     * Exibe o formulário de edição da foto.
     * Só o dono pode editar.
     */
    public function edit(Foto $foto)
    {
        abort_unless($foto->user_id === Auth::id(), 403);

        $albums = Album::where('user_id', Auth::id())->orderBy('nome')->get();
        $tags   = Tag::orderBy('nome')->get();

        $foto->load('tags'); // Carrega tags atuais para pré-selecionar checkboxes

        return view('fotos.edit', compact('foto', 'albums', 'tags'));
    }

    /**
     * Atualiza os dados da foto.
     * Se uma nova imagem for enviada, a anterior é removida do disco.
     * Tags são sincronizadas (sync substitui completamente as tags anteriores).
     */
    public function update(UpdateFotoRequest $request, Foto $foto)
    {
        abort_unless($foto->user_id === Auth::id(), 403);

        $validated = $request->validated();

        if ($request->hasFile('imagem')) {
            // Remove a imagem anterior do disco antes de salvar a nova
            Storage::disk('public')->delete($foto->imagem);
            $validated['imagem'] = $request->file('imagem')->store('fotos', 'public');
        } else {
            // Mantém a imagem atual se nenhuma nova foi enviada
            $validated['imagem'] = $foto->imagem;
        }

        $foto->update([
            'album_id'  => $validated['album_id'],
            'titulo'    => $validated['titulo'],
            'descricao' => $validated['descricao'] ?? null,
            'imagem'    => $validated['imagem'],
            'publico'   => $validated['publico'],
        ]);

        // sync() remove as tags desmarcadas e mantém/adiciona as selecionadas
        $foto->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('fotos.index')
            ->with('success', 'Foto atualizada com sucesso.');
    }

    /**
     * Remove a foto e sua imagem do disco.
     * Desvincula todas as tags antes de deletar (limpeza da pivot).
     */
    public function destroy(Foto $foto)
    {
        abort_unless($foto->user_id === Auth::id(), 403);

        // Remove arquivo do disco de armazenamento público
        Storage::disk('public')->delete($foto->imagem);

        // Remove vínculos com tags para limpar a tabela pivot
        $foto->tags()->detach();

        $foto->delete();

        return redirect()->route('fotos.index')
            ->with('success', 'Foto excluída com sucesso.');
    }
}
