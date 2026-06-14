{{-- Galeria pública --}}

@extends('layouts.app')
@include('layouts.navigation')

@section('title', 'Galeria')

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Galeria Pública ]</p>
            <h1 class="page-header__title">Klipt</h1>
        </div>
        @if (Auth::guest())
            <a href="{{ route('register') }}" class="btn btn--ghost">
                Criar Conta
            </a>
        @endif
    </div>

    {{-- grid de fotos públicas --}}
    @if($fotos->count())
        <div class="grid-masonry">
            @foreach($fotos as $foto)

                @if($foto->publico)
                <div class="card">
                    {{-- Imagem da foto com link para detalhes --}}
                    @if($foto->imagem)
                        <a href="{{ route('public.foto', $foto) }}">
                            <img src="{{ Storage::url($foto->imagem) }}"
                                 alt="{{ $foto->titulo }}"
                                 class="card__img">
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

                       @if(!empty($foto->imagem))
                            <a href="{{ route('foto.download', ['filename' => $foto->imagem]) }}" download class="btn btn-dowload">
                                Baixar Imagem
                            </a>
                        @else
                            <button class="btn btn-secondary" disabled title="Nenhum arquivo disponível">
                                Sem Imagem
                            </button>
                        @endif

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