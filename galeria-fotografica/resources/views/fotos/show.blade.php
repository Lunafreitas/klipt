{{--
    Detalhe de foto para o dono autenticado.
    O controller já valida que foto.user_id === Auth::id() antes de chegar aqui.
--}}
@extends('layouts.app')

@section('title', $foto->titulo)

@section('content')

    <p class="text-mono text-sm text-muted mb-md">
        <a href="{{ route('fotos.index') }}" style="color:inherit;text-decoration:none;">Minhas Fotos</a>
        &nbsp;/&nbsp; {{ $foto->titulo }}
    </p>

    <div style="display:grid;grid-template-columns:1fr 300px;gap:var(--gap-lg);align-items:start;">

        <div>
            @if($foto->imagem)
                <img src="{{ Storage::url($foto->imagem) }}"
                     alt="{{ $foto->titulo }}"
                     style="width:100%;border:2px solid var(--c-border);display:block;">
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
                <p style="font-size:14px;color:var(--c-ink-muted);margin-top:var(--gap-md);line-height:1.6;">
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
    </div>

    <style>
        @media (max-width: 768px) {
            div[style*="grid-template-columns:1fr 300px"] { grid-template-columns: 1fr !important; }
        }
    </style>

@endsection
