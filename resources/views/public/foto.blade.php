@extends('layouts.app')
@include('layouts.navigation')

@section('title', $foto->titulo)

@section('content')

    <p class="text-mono text-sm text-muted mb-md">
        <a href="{{ auth()->check() ? route('fotos.index') : route('public.index') }}" style="color:inherit;text-decoration:none;">
            {{ auth()->check() ? 'Minhas Fotos' : 'Galeria Pública' }}
        </a>
        &nbsp;/&nbsp; {{ $foto->titulo }}
    </p>

    <div class="info-img">

        <div>
            @if($foto->imagem)
                <img src="{{ Storage::url($foto->imagem) }}"
                     alt="{{ $foto->titulo }}"
                     class="img-show">
            @endif
        </div>

        <aside>
            <p class="page-header__eyebrow section-bracket">Foto</p>
            <h1 style="font-size:24px;font-weight:700;letter-spacing:-0.02em;text-transform:uppercase;margin-bottom:var(--gap-md);">
                {{ $foto->titulo }}
            </h1>

            {{-- Visibilidade --}}
            <span class="vis-badge {{ $foto->publico ? 'vis-badge--pub' : 'vis-badge--priv' }}" style="margin-bottom:var(--gap-md);display:inline-block;">
                {{ $foto->publico ? 'Público' : 'Privado' }}
            </span>

            @if($foto->descricao)
                <p class="desc">
                    {{ $foto->descricao }}
                </p>
            @endif

            @if($foto->album)
                <div style="margin-top:var(--gap-md);padding-top:var(--gap-md);border-top:1px solid var(--c-border-lt);">
                    <p class="form-label">Álbum</p>
                    <p style="font-size:14px;font-weight:500;">{{ $foto->album->nome }}</p>
                </div>
            @endif

            @if($foto->tags->count())
                <div style="margin-top:var(--gap-md);">
                    <p class="form-label">Tags</p>
                    <div class="flex flex-wrap gap-sm">
                        @foreach($foto->tags as $tag)
                            <span class="tag-pill">{{ $tag->nome }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>

        <div class="f-view" style="max-width:600px;">
        @if(isset($fotos) && $fotos->count())
            <div class="f-grid">
                
            @foreach($fotos->take(3) as $f) 
                <div class="f-card"> 
                    @if($f->imagem) 
                        <a href="{{ route('public.foto', $f) }}"> 
                            <img src="{{ asset('storage/' . $f->imagem) }}" alt="{{ $f->titulo }}" class="f-img" style="aspect-ratio:unset;height:auto;"> 
                        </a> 
                    @endif 
                    <div class="card__body"> 
                        <div class="flex items-center justify-between mb-md" style="gap:8px;"> 
                            <p class="f-title"> 
                                <a href="{{ route('public.foto', $f) }}"> {{ $f->titulo }} </a> 
                            </p> 
                        </div> 
                        @if($f->album) 
                            <p class="card__meta">{{ $f->album->nome }}</p> 
                        @endif 
                    </div> 
                </div> 
            @endforeach
            
            <a href="{{ route('public.fotografo', $foto->user_id) }}" class="btn btn--primary" style="width:100%;">Ver mais fotos desse autor</a>
            </div>
        @endif
        </div>
        
    </div>
@endsection