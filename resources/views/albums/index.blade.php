@extends('layouts.app')
@include('layouts.navigation')
@section('title', 'Meus Álbuns')

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Painel ]</p>
            <h1 class="page-header__title">Meus Álbuns</h1>
        </div>
        <a href="{{ route('albums.create') }}" class="btn btn--primary">
            + Novo Álbum
        </a>
    </div>

    @if($albums->count())
        <div class="grid-std">
            @foreach($albums as $album)
            <div class="card">
                <div class="card__body">
                    <div class="flex items-center justify-between mb-md">
                        <p class="card__title" style="flex:1;">{{ $album->nome }}</p>
                        <span class="vis-badge {{ $album->publico ? 'vis-badge--pub' : 'vis-badge--priv' }}">
                            {{ $album->publico ? 'Público' : 'Privado' }}
                        </span>
                    </div>

                    @if($album->descricao)
                        <p style="font-size:13px;color:var(--c-ink-muted);margin-bottom:8px;line-height:1.5;">
                            {{ Str::limit($album->descricao, 80) }}
                        </p>
                    @endif

                    <p class="card__meta">
                        {{ $album->fotos_count ?? 0 }} foto(s)
                        &nbsp;·&nbsp;
                        Criado {{ $album->created_at->diffForHumans() }}
                    </p>
                </div>

                <div class="card__actions">
                    <a href="{{ route('albums.show', $album) }}" class="btn btn--ghost btn--sm">
                        Ver
                    </a>
                    <a href="{{ route('albums.edit', $album) }}" class="btn btn--ghost btn--sm">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('albums.destroy', $album) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn--danger btn--sm"
                                onclick="return confirm('Excluir este álbum? As fotos vinculadas serão mantidas.')">
                            Excluir
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

    @else
        <div class="empty-state">
            <div class="empty-state__icon">X</div>
            <p class="empty-state__title">Nenhum álbum</p>
            <p class="empty-state__text">Crie seu primeiro álbum para organizar suas fotos.</p>
            <a href="{{ route('albums.create') }}" class="btn btn--primary">
                Criar Álbum
            </a>
        </div>
    @endif

@endsection