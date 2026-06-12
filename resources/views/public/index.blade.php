{{--
    Galeria pública — página inicial acessível a todos (visitantes, usuários e admin).
    Exibe fotos públicas em layout masonry inspirado no Pinterest.
    Visitantes vêem tudo mas não podem gerenciar conteúdo.
--}}
@auth
    @extends('layouts.app')
    @if(auth()->user()->is_admin)
        @extends('layouts.admin_layout')
    @endif
@endauth

@section('title', 'Galeria')

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Galeria Pública ]</p>
            <h1 class="page-header__title">Klipt</h1>
        </div>
        @auth
            <a href="{{ route('fotos.create') }}" class="btn btn--primary">
                + Nova Foto
            </a>
        @else
            <a href="{{ route('register') }}" class="btn btn--ghost">
                Criar Conta
            </a>
        @endauth
    </div>

    {{-- Grid masonry de fotos públicas --}}
    @if($fotos->count())
        <div class="grid-masonry">
            @foreach($fotos as $foto)
                {{-- Exibe apenas fotos marcadas como públicas --}}
                @if($foto->publico)
                <div class="card">
                    {{-- Imagem da foto com link para detalhes --}}
                    @if($foto->imagem)
                        <a href="{{ route('public.foto', $foto) }}">
                            <img src="{{ Storage::url($foto->imagem) }}"
                                 alt="{{ $foto->titulo }}"
                                 class="card__img"
                                 style="aspect-ratio: unset; height: auto;">
                        </a>
                    @endif

                    <div class="card__body">
                        <p class="card__title">
                            <a href="{{ route('public.foto', $foto) }}"
                               style="text-decoration:none;color:inherit;">
                                {{ $foto->titulo }}
                            </a>
                        </p>

                        {{-- Metadados: autor e álbum --}}
                        <p class="card__meta">
                            {{ $foto->user->name }}
                            @if($foto->album)
                                &nbsp;·&nbsp; {{ $foto->album->nome }}
                            @endif
                        </p>

                        {{-- Tags da foto --}}
                        @if($foto->tags->count())
                            <div class="flex flex-wrap gap-sm" style="margin-top:8px;">
                                @foreach($foto->tags as $tag)
                                    <a href="{{ route('public.tag', $tag) }}" class="tag-pill">
                                        {{ $tag->nome }}
                                    </a>
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
            <p class="empty-state__title">Nenhuma foto ainda</p>
            <p class="empty-state__text">Seja o primeiro a publicar na galeria.</p>
            @auth
                <a href="{{ route('fotos.create') }}" class="btn btn--primary">
                    Enviar Foto
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn--primary">
                    Criar Conta
                </a>
            @endauth
        </div>
    @endif

@endsection
