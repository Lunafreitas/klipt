@extends('layouts.app')
@include('layouts.navigation')

@section('title', $album->nome)

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">
                Álbum de
                <a href="{{ route('public.fotografo', $album->user) }}"
                   style="color:inherit;text-decoration:none;">
                    {{ $album->user->name }}
                </a>
            </p>
            <h1 class="page-header__title">{{ $album->nome }}</h1>
        </div>
    </div>

    @if($album->descricao)
        <p style="font-size:14px;color:var(--c-ink-muted);margin-bottom:var(--gap-lg);max-width:600px;line-height:1.6;">
            {{ $album->descricao }}
        </p>
    @endif

    @if($album->fotos->count())
        <div class="grid-masonry">
            @foreach($album->fotos as $foto)
                @if($foto->publico)
                <div class="card">
                    @if($foto->imagem)
                        <a href="{{ route('public.foto', $foto) }}">
                            <img src="{{ Storage::url($foto->imagem) }}"
                                 alt="{{ $foto->titulo }}"
                                 class="card__img"
                                 style="aspect-ratio:unset;height:auto;">
                        </a>
                    @endif
                    <div class="card__body">
                        <p class="card__title">
                            <a href="{{ route('public.foto', $foto) }}" style="text-decoration:none;color:inherit;">
                                {{ $foto->titulo }}
                            </a>
                        </p>
                        @if($foto->tags->count())
                            <div class="flex flex-wrap gap-sm mt-sm">
                                @foreach($foto->tags as $tag)
                                    <a href="{{ route('public.tag', $tag) }}" class="tag-pill">{{ $tag->nome }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state__icon">X</div>
            <p class="empty-state__title">Álbum vazio</p>
            <p class="empty-state__text">Nenhuma foto pública neste álbum.</p>
        </div>
    @endif

@endsection
