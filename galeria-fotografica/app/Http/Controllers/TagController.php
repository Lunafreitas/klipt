<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

/**
 * Controlador de Tags (Categorias).
 *
 * Acesso restrito ao administrador via AdminMiddleware aplicado nas rotas.
 * Tags são globais — qualquer usuário pode usá-las nas fotos,
 * mas apenas o admin pode criar, editar e excluir.
 */
class TagController extends Controller
{
    /**
     * Lista todas as tags com contagem de fotos vinculadas.
     */
    public function index()
    {
        $tags = Tag::withCount('fotos') // Exibe total de fotos por tag na tabela
            ->latest()
            ->paginate(15);

        return view('tags.index', compact('tags'));
    }

    /**
     * Exibe o formulário de criação de tag.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Persiste uma nova tag com validação de unicidade do nome.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Nome obrigatório, único na tabela tags (case-insensitive no MySQL)
            'nome' => ['required', 'string', 'max:255', 'unique:tags,nome'],
        ]);

        Tag::create($validated);

        return redirect()->route('tags.index')
            ->with('success', 'Tag criada com sucesso.');
    }

    /**
     * Exibe o formulário de edição de tag.
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    /**
     * Atualiza o nome da tag ignorando o ID atual na regra de unicidade.
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            // Ignora o próprio registro na verificação de unicidade
            'nome' => ['required', 'string', 'max:255', 'unique:tags,nome,' . $tag->id],
        ]);

        $tag->update($validated);

        return redirect()->route('tags.index')
            ->with('success', 'Tag atualizada com sucesso.');
    }

    /**
     * Remove a tag e seus vínculos com fotos (via cascade no pivot).
     */
    public function destroy(Tag $tag)
    {
        // O Laravel remove automaticamente os registros da tabela pivot foto_tag
        $tag->delete();

        return redirect()->route('tags.index')
            ->with('success', 'Tag excluída com sucesso.');
    }
}
