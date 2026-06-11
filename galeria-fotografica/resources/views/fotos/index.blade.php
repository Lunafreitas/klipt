{{--
    Lista de fotos do usuário autenticado.
    Usuário comum vê apenas suas próprias fotos (filtrado no controller via Auth::id()).
--}}
@extends('layouts.app')

@section('title', 'Minhas Fotos')

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Painel ]</p>
            <h1 class="page-header__title">Minhas Fotos</h1>
        </div>
        <a href="{{ route('fotos.create') }}" class="btn btn--primary">
            + Nova Foto
        </a>
    </div>

    @if($fotos->count())
        <div class="grid-masonry">
            @foreach($fotos as $foto)
            <div class="card">
                {{-- Imagem ou placeholder --}}
                @if($foto->imagem)
                    <a href="{{ route('fotos.show', $foto) }}">
                        <img src="{{ Storage::url($foto->imagem) }}"
                             alt="{{ $foto->titulo }}"
                             class="card__img"
                             style="aspect-ratio:unset;height:auto;">
                    </a>
                @endif

                <div class="card__body">
                    <div class="flex items-center justify-between mb-md" style="gap:8px;">
                        <p class="card__title" style="flex:1;">
                            <a href="{{ route('fotos.show', $foto) }}" style="text-decoration:none;color:inherit;">
                                {{ $foto->titulo }}
                            </a>
                        </p>
                        {{-- Badge de visibilidade --}}
                        <span class="vis-badge {{ $foto->publico ? 'vis-badge--pub' : 'vis-badge--priv' }}">
                            {{ $foto->publico ? 'Público' : 'Privado' }}
                        </span>
                    </div>

                    {{-- Álbum vinculado --}}
                    @if($foto->album)
                        <p class="card__meta">{{ $foto->album->nome }}</p>
                    @endif

                    {{-- Tags --}}
                    @if($foto->tags->count())
                        <div class="flex flex-wrap gap-sm" style="margin-top:8px;">
                            @foreach($foto->tags as $tag)
                                <span class="tag-pill">{{ $tag->nome }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Ações rápidas --}}
                <div class="card__actions">
                    <a href="{{ route('fotos.edit', $foto) }}" class="btn btn--ghost btn--sm">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('fotos.destroy', $foto) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn--danger btn--sm"
                                onclick="return confirm('Excluir esta foto permanentemente?')">
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
            <p class="empty-state__title">Nenhuma foto ainda</p>
            <p class="empty-state__text">Envie sua primeira foto para começar.</p>
            <a href="{{ route('fotos.create') }}" class="btn btn--primary">
                Enviar Foto
            </a>
        </div>
    @endif

@endsection
