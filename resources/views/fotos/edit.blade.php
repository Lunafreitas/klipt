{{--
    Formulário de edição de foto.
    O controller verifica foto.user_id === Auth::id() antes de renderizar.
    Se nenhuma nova imagem for enviada, mantém a imagem atual.
--}}
@extends('layouts.app')

@section('title', 'Editar: ' . $foto->titulo)

@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Editar Foto ]</p>
            <h1 class="page-header__title">{{ Str::limit($foto->titulo, 30) }}</h1>
        </div>
        <a href="{{ route('fotos.show', $foto) }}" class="btn btn--ghost">
            ← Voltar
        </a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('fotos.update', $foto) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- Álbum --}}
            <div class="form-group">
                <label class="form-label" for="album_id">Álbum *</label>
                <select id="album_id" name="album_id" class="form-control" required>
                    @foreach($albums as $album)
                        <option value="{{ $album->id }}"
                                {{ old('album_id', $foto->album_id) == $album->id ? 'selected' : '' }}>
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
                       class="form-control" value="{{ old('titulo', $foto->titulo) }}"
                       required maxlength="255">
                @error('titulo') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Descrição --}}
            <div class="form-group">
                <label class="form-label" for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao"
                          class="form-control" rows="3"
                          style="resize:vertical;">{{ old('descricao', $foto->descricao) }}</textarea>
                @error('descricao') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Imagem atual e substituição --}}
            <div class="form-group">
                <label class="form-label">Imagem Atual</label>
                @if($foto->imagem)
                    <img src="{{ Storage::url($foto->imagem) }}"
                         alt="Imagem atual"
                         style="max-width:200px;max-height:150px;object-fit:cover;border:1px solid var(--c-border-lt);display:block;margin-bottom:8px;">
                @endif
                <label class="form-label" for="imagem" style="margin-top:8px;">
                    Nova imagem (deixe em branco para manter a atual)
                </label>
                <input id="imagem" type="file" name="imagem" class="form-control" accept="image/*">
                @error('imagem') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Visibilidade --}}
            <div class="form-group">
                <label class="form-label">Visibilidade *</label>
                <div style="display:flex;gap:var(--gap-md);">
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;">
                        <input type="radio" name="publico" value="1"
                               {{ old('publico', $foto->publico) == '1' ? 'checked' : '' }}>
                        Pública
                    </label>
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;">
                        <input type="radio" name="publico" value="0"
                               {{ old('publico', $foto->publico) == '0' ? 'checked' : '' }}>
                        Privada
                    </label>
                </div>
                @error('publico') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            {{-- Tags --}}
            @if($tags->count())
                <div class="form-group">
                    <label class="form-label">Tags</label>
                    {{-- IDs das tags já vinculadas a esta foto --}}
                    @php $tagsAtivas = $foto->tags->pluck('id')->toArray(); @endphp
                    <div style="display:flex;flex-wrap:wrap;gap:var(--gap-sm);padding:12px;border:2px solid var(--c-border);background:#FFF;">
                        @foreach($tags as $tag)
                            <label style="display:flex;align-items:center;gap:5px;cursor:pointer;font-size:12px;font-family:var(--f-mono);">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                       {{ in_array($tag->id, old('tags', $tagsAtivas)) ? 'checked' : '' }}>
                                {{ $tag->nome }}
                            </label>
                        @endforeach
                    </div>
                    @error('tags') <p class="form-error">{{ $message }}</p> @enderror
                </div>
            @endif

            <div style="display:flex;gap:var(--gap-sm);margin-top:var(--gap-lg);">
                <button type="submit" class="btn btn--primary">
                    Salvar Alterações
                </button>
                <a href="{{ route('fotos.show', $foto) }}" class="btn btn--ghost">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

@endsection
