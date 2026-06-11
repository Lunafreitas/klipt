{{--
    Formulário de criação de foto.
    Requer autenticação — o controller usa Auth::id() para definir user_id.
    O álbum selecionado deve pertencer ao usuário autenticado (validado no FormRequest).
--}}
@extends('layouts.app')

@section('title', 'Nova Foto')

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Nova Foto ]</p>
            <h1 class="page-header__title">Enviar Foto</h1>
        </div>
        <a href="{{ route('fotos.index') }}" class="btn btn--ghost">
            ← Voltar
        </a>
    </div>

    {{-- Aviso caso não haja álbuns criados ainda --}}
    @if($albums->isEmpty())
        <div class="flash flash--error">
            ✗ &nbsp;Você precisa criar um álbum antes de enviar fotos.
            <a href="{{ route('albums.create') }}" style="color:#FFF;font-weight:700;margin-left:8px;">
                Criar Álbum →
            </a>
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('fotos.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Álbum de destino --}}
            <div class="form-group">
                <label class="form-label" for="album_id">Álbum *</label>
                <select id="album_id" name="album_id" class="form-control" required>
                    <option value="">Selecione um álbum</option>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}"
                                {{ old('album_id') == $album->id ? 'selected' : '' }}>
                            {{ $album->nome }}
                        </option>
                    @endforeach
                </select>
                @error('album_id') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Título --}}
            <div class="form-group">
                <label class="form-label" for="titulo">Título *</label>
                <input id="titulo" type="text" name="titulo"
                       class="form-control" value="{{ old('titulo') }}" required maxlength="255">
                @error('titulo') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Descrição opcional --}}
            <div class="form-group">
                <label class="form-label" for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao"
                          class="form-control" rows="3"
                          style="resize:vertical;">{{ old('descricao') }}</textarea>
                @error('descricao') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Upload de imagem --}}
            <div class="form-group">
                <label class="form-label" for="imagem">Imagem * (máx. 4 MB)</label>
                <input id="imagem" type="file" name="imagem"
                       class="form-control" accept="image/*" required>
                @error('imagem') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Visibilidade --}}
            <div class="form-group">
                <label class="form-label">Visibilidade *</label>
                <div style="display:flex;gap:var(--gap-md);">
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;">
                        <input type="radio" name="publico" value="1"
                               {{ old('publico', '1') == '1' ? 'checked' : '' }}>
                        Pública
                    </label>
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;">
                        <input type="radio" name="publico" value="0"
                               {{ old('publico') == '0' ? 'checked' : '' }}>
                        Privada
                    </label>
                </div>
                @error('publico') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Tags (multi-select) --}}
            @if($tags->count())
                <div class="form-group">
                    <label class="form-label">Tags</label>
                    <div style="display:flex;flex-wrap:wrap;gap:var(--gap-sm);padding:12px;border:2px solid var(--c-border);background:#FFF;">
                        @foreach($tags as $tag)
                            <label style="display:flex;align-items:center;gap:5px;cursor:pointer;font-size:12px;font-family:var(--f-mono);">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                       {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                {{ $tag->nome }}
                            </label>
                        @endforeach
                    </div>
                    @error('tags') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            @endif

            <div style="display:flex;gap:var(--gap-sm);margin-top:var(--gap-lg);">
                <button type="submit" class="btn btn--primary">
                    Enviar Foto
                </button>
                <a href="{{ route('fotos.index') }}" class="btn btn--ghost">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

@endsection
