{{--
    Detalhe de álbum para o dono autenticado.
    Exibe todas as fotos do álbum (públicas e privadas).
--}}
@extends('layouts.app')

@section('title', $album->nome)

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">
                <a href="{{ route('albums.index') }}" style="color:inherit;text-decoration:none;">
                    Meus Álbuns
                </a>
                &nbsp;/
            </p>
            <h1 class="page-header__title">{{ $album->nome }}</h1>
        </div>
        <div style="display:flex;gap:var(--gap-sm);">
            <a href="{{ route('fotos.create') }}" class="btn btn--primary">
                + Foto
            </a>
            <a href="{{ route('albums.edit', $album) }}" class="btn btn--ghost">
                Editar
            </a>
        </div>
    </div>

    @if($album->descricao)
        <p style="font-size:14px;color:var(--c-ink-muted);margin-bottom:var(--gap-lg);line-height:1.6;max-width:600px;">
            {{ $album->descricao }}
        </p>
    @endif

    {{-- Fotos do álbum --}}
    @if($album->fotos->count())
        <div class="grid-masonry">
            @foreach($album->fotos as $foto)
            <div class="card">
                @if($foto->imagem)
                    <a href="{{ route('fotos.show', $foto) }}">
                        <img src="{{ Storage::url($foto->imagem) }}" alt="{{ $foto->titulo }}"
                             class="card__img" style="aspect-ratio:unset;height:auto;">
                    </a>
                @endif
                <div class="card__body">
                    <div class="flex items-center justify-between">
                        <p class="card__title" style="flex:1;">{{ $foto->titulo }}</p>
                        <span class="vis-badge {{ $foto->publico ? 'vis-badge--pub' : 'vis-badge--priv' }}">
                            {{ $foto->publico ? 'Pub' : 'Priv' }}
                        </span>
                    </div>
                    @if($foto->tags->count())
                        <div class="flex flex-wrap gap-sm mt-sm">
                            @foreach($foto->tags as $tag)
                                <span class="tag-pill">{{ $tag->nome }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="card__actions">
                    <a href="{{ route('fotos.edit', $foto) }}" class="btn btn--ghost btn--sm">Editar</a>
                    <form method="POST" action="{{ route('fotos.destroy', $foto) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn--danger btn--sm"
                                onclick="return confirm('Excluir?')">Excluir</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state__icon">◻</div>
            <p class="empty-state__title">Álbum vazio</p>
            <p class="empty-state__text">Adicione fotos a este álbum.</p>
            <a href="{{ route('fotos.create') }}" class="btn btn--primary">Enviar Foto</a>
        </div>
    @endif

@endsection
