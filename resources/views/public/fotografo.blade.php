{{--
    Perfil público de um fotógrafo — exibe álbuns e fotos públicos do usuário.
--}}

@extends('layouts.app')
@include('layouts.navigation')

@section('title', $user->name)

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow section-bracket">Fotógrafo</p>
            <h1 class="page-header__title">{{ $user->name }}</h1>
        </div>
    </div>

    {{-- Álbuns públicos do fotógrafo --}}
    @php
        $albumsPublicos = $user->albums->where('publico', true);
    @endphp

    @if($albumsPublicos->count())
        <section class="mb-lg">
            <h2 style="font-size:14px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:var(--gap-md);padding-bottom:8px;border-bottom:1px solid var(--c-border-lt);">
                Álbuns
            </h2>
            <div class="grid-std">
                @foreach($albumsPublicos as $album)
                    <a href="{{ route('public.album', $album) }}"
                       style="display:block;text-decoration:none;color:inherit;border:1px solid var(--c-border-lt);padding:var(--gap-md);background:#FFF;transition:border-color .15s;"
                       onmouseover="this.style.borderColor='#0A0A0A'" onmouseout="this.style.borderColor='#D0CEC9'">
                        <p style="font-size:14px;font-weight:600;margin-bottom:4px;">{{ $album->nome }}</p>
                        <p class="card__meta">{{ $album->fotos->where('publico',true)->count() }} fotos</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Fotos públicas recentes --}}
    @php
        $fotosPublicas = $user->fotos->where('publico', true);
    @endphp
    
    @if($fotosPublicas->count())
        <section>
            <h2 style="font-size:14px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:var(--gap-md);padding-bottom:8px;border-bottom:1px solid var(--c-border-lt);">
                Fotos
            </h2>
            <div class="grid-masonry">
                @foreach($fotosPublicas as $foto)
                    <div class="card">
                        @if($foto->imagem)
                            <a href="{{ route('public.foto', $foto) }}">
                                <img src="{{ Storage::url($foto->imagem) }}" alt="{{ $foto->titulo }}"
                                     class="card__img">
                            </a>
                        @endif
                        <div class="card__body">
                            <p class="card__title">
                                <a href="{{ route('public.foto', $foto) }}" style="text-decoration:none;color:inherit;">
                                    {{ $foto->titulo }}
                                </a>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if($albumsPublicos->isEmpty() && $fotosPublicas->isEmpty())
        <div class="empty-state">
            <div class="empty-state__icon">X</div>
            <p class="empty-state__title">Nenhum conteúdo público</p>
            <p class="empty-state__text">Este fotógrafo ainda não publicou conteúdo.</p>
        </div>
    @endif

@endsection