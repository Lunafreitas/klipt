{{--
    Detalhe de foto para o dono autenticado.
    O controller já valida que foto.user_id === Auth::id() antes de chegar aqui.
--}}

@extends('layouts.app')
@include('layouts.navigation')

@section('title', $foto->titulo)

@section('content')

    <p class="text-mono text-sm text-muted mb-md">
        <a href="{{ route('fotos.index') }}" style="color:inherit;text-decoration:none;">Minhas Fotos</a>
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

            {{-- Ações do dono --}}
            <div style="margin-top:var(--gap-lg);display:flex;gap:var(--gap-sm);">
                <a href="{{ route('fotos.edit', $foto) }}" class="btn btn--ghost btn--sm">
                    Editar
                </a>
                <form method="POST" action="{{ route('fotos.destroy', $foto) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn--danger btn--sm"
                            onclick="return confirm('Excluir esta foto?')">
                        Excluir
                    </button>
                </form>
            </div>
        </aside>

        <div class="f-view" style="max-width:600px;">
        @if($fotos->count())
            <div class="f-grid">
                @foreach($fotos as $foto)
                    <div class="f-card">
                        
                        {{-- Imagem ou placeholder --}}
                        @if($foto->imagem)
                            <a href="{{ route('fotos.show', $foto) }}">
                                <img src="{{ asset('storage/' . $foto->imagem) }}" alt="{{ $foto->titulo }}" class="f-img" style="aspect-ratio:unset;height:auto;">
                            </a>
                        @endif
    
                        <div class="card__body">
                            <div class="flex items-center justify-between mb-md" style="gap:8px;">
                                <p class="f-title">
                                    <a href="{{ route('fotos.show', $foto) }}">
                                        {{ $foto->titulo }}
                                    </a>
                                </p>
                            </div>
    
                            {{-- Álbum vinculado --}}
                            @if($foto->album)
                                <p class="card__meta">{{ $foto->album->nome }}</p>
                            @endif
                        </div>
    
                    </div>
                @endforeach
            </div>
        @endif
        </div>
        
    </div>
@endsection