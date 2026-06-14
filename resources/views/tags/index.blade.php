{{--
    Lista de tags — acessível apenas ao admin (protegido pelo AdminMiddleware nas rotas).
    Tags são globais; qualquer usuário pode aplicá-las às fotos, mas apenas o admin gerencia.
--}}

@extends('layouts.app')
@include('layouts.navigation')
@section('title', 'Gerenciar Tags')
@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Admin ]</p>
            <h1 class="page-header__title">Tags</h1>
        </div>
        <a href="{{ route('tags.create') }}" class="btn btn--primary">+ Nova Tag</a>
    </div>

    @if($tags->count())
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Fotos</th>
                        <th>Criada</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                    <tr>
                        <td class="text-mono text-sm text-muted">{{ $tag->id }}</td>
                        <td>
                            <a href="{{ route('public.tag', $tag) }}" class="tag-pill">
                                {{ $tag->nome }}
                            </a>
                        </td>
                        <td class="text-mono text-sm">{{ $tag->fotos_count ?? '—' }}</td>
                        <td class="text-mono text-sm text-muted">
                            {{ $tag->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <div style="display:flex;gap:var(--gap-sm);">
                                <a href="{{ route('tags.edit', $tag) }}" class="btn btn--ghost btn--sm">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('tags.destroy', $tag) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--danger btn--sm"
                                            onclick="return confirm('Excluir a tag {{ $tag->nome }}?')">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        <div class="empty-state">
            <div class="empty-state__icon">X</div>
            <p class="empty-state__title">Nenhuma tag</p>
            <p class="empty-state__text">Crie tags para categorizar as fotos da plataforma.</p>
            <a href="{{ route('tags.create') }}" class="btn btn--primary">Nova Tag</a>
        </div>
    @endif

@endsection