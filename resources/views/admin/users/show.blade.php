{{--
    Detalhe de usuário — admin visualiza todos os álbuns e fotos do usuário selecionado.
    Admin pode ver conteúdo privado (é a distinção de permissão para admin).
--}}
@extends('layouts.app')
@include('layouts.navigation')
@section('title', 'Usuário: ' . $user->name)
@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">
                <a href="{{ route('usuarios.index') }}" style="color:inherit;text-decoration:none;">
                    Usuários
                </a>
                &nbsp;/
            </p>
            <h1 class="page-header__title">{{ $user->name }}</h1>
        </div>
        @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('usuarios.destroy', $user) }}">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn--danger"
                        onclick="return confirm('Excluir permanentemente o usuário {{ $user->name }}?')">
                    Excluir Usuário
                </button>
            </form>
        @endif
    </div>

    {{-- Dados do usuário --}}
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:var(--gap-md);margin-bottom:var(--gap-lg);">
        <div style="padding:var(--gap-md);border:1px solid var(--c-border-lt);background:#FFF;">
            <p class="form-label">E-mail</p>
            <p style="font-size:14px;">{{ $user->email }}</p>
        </div>
        <div style="padding:var(--gap-md);border:1px solid var(--c-border-lt);background:#FFF;">
            <p class="form-label">Álbuns</p>
            <p style="font-size:24px;font-weight:700;">{{ $user->albums->count() }}</p>
        </div>
        <div style="padding:var(--gap-md);border:1px solid var(--c-border-lt);background:#FFF;">
            <p class="form-label">Fotos</p>
            <p style="font-size:24px;font-weight:700;">{{ $user->fotos->count() }}</p>
        </div>
    </div>

    {{-- Álbuns do usuário (admin vê todos, incluindo privados) --}}
    @if($user->albums->count())
        <section class="mb-lg">
            <h2 style="font-size:13px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:var(--gap-md);padding-bottom:8px;border-bottom:1px solid var(--c-border-lt);">
                Álbuns
            </h2>
            <div class="grid-std">
                @foreach($user->albums as $album)
                    <div style="padding:var(--gap-md);border:1px solid var(--c-border-lt);background:#FFF;">
                        <div class="flex items-center justify-between mb-md">
                            <p style="font-size:14px;font-weight:600;">{{ $album->nome }}</p>
                            <span class="vis-badge {{ $album->publico ? 'vis-badge--pub' : 'vis-badge--priv' }}">
                                {{ $album->publico ? 'Público' : 'Privado' }}
                            </span>
                        </div>
                        <p class="card__meta">{{ $album->fotos->count() }} foto(s)</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Fotos recentes do usuário (admin vê todas) --}}
    @if($user->fotos->count())
        <section>
            <h2 style="font-size:13px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:var(--gap-md);padding-bottom:8px;border-bottom:1px solid var(--c-border-lt);">
                Fotos
            </h2>
            <div class="grid-masonry">
                @foreach($user->fotos->take(20) as $foto)
                    <div class="card">
                        @if($foto->imagem)
                            <img src="{{ Storage::url($foto->imagem) }}" alt="{{ $foto->titulo }}"
                                 class="card__img">
                        @endif
                        <div class="card__body">
                            <div class="flex items-center justify-between">
                                <p class="card__title" style="flex:1;">{{ $foto->titulo }}</p>
                                <span class="vis-badge {{ $foto->publico ? 'vis-badge--pub' : 'vis-badge--priv' }}">
                                    {{ $foto->publico ? 'Pub' : 'Priv' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

@endsection