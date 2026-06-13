{{-- Formulário de edição de álbum — controller verifica propriedade antes de renderizar --}}

@extends('layouts.app')
@include('layouts.navigation')
@section('title', 'Editar: ' . $album->nome)
@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Editar Álbum ]</p>
            <h1 class="page-header__title">{{ Str::limit($album->nome, 30) }}</h1>
        </div>
        <a href="{{ route('albums.show', $album) }}" class="btn btn--ghost">← Voltar</a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('albums.update', $album) }}">
            @csrf @method('PUT')

            <div class="form-group">
                <label class="form-label" for="nome">Nome *</label>
                <input id="nome" type="text" name="nome"
                       class="form-control" value="{{ old('nome', $album->nome) }}" required maxlength="255">
                @error('nome') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao"
                          class="form-control" rows="3"
                          style="resize:vertical;">{{ old('descricao', $album->descricao) }}</textarea>
                @error('descricao') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Visibilidade *</label>
                <div style="display:flex;gap:var(--gap-md);">
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;">
                        <input type="radio" name="publico" value="1"
                               {{ old('publico', $album->publico) == '1' ? 'checked' : '' }}>
                        Público
                    </label>
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;">
                        <input type="radio" name="publico" value="0"
                               {{ old('publico', $album->publico) == '0' ? 'checked' : '' }}>
                        Privado
                    </label>
                </div>
                @error('publico') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div style="display:flex;gap:var(--gap-sm);margin-top:var(--gap-lg);">
                <button type="submit" class="btn btn--primary">Salvar</button>
                <a href="{{ route('albums.index') }}" class="btn btn--ghost">Cancelar</a>
            </div>
        </form>
    </div>

@endsection