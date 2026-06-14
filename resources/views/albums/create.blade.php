{{-- Formulário de criação de álbum --}}

@extends('layouts.app')
@include('layouts.navigation')
@section('title', 'Novo Álbum')
@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Novo Álbum ]</p>
            <h1 class="page-header__title">Criar Álbum</h1>
        </div>
        <a href="{{ route('albums.index') }}" class="btn btn--ghost">← Voltar</a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('albums.store') }}">
            @csrf

            <div class="form-group">
                <label class="form-label" for="nome">Nome *</label>
                <input id="nome" type="text" name="nome"
                       class="form-control" value="{{ old('nome') }}" required maxlength="255">
                @error('nome') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao"
                          class="form-control" rows="3"
                          style="resize:vertical;">{{ old('descricao') }}</textarea>
                @error('descricao') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Visibilidade *</label>
                <div style="display:flex;gap:var(--gap-md);">
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;">
                        <input type="radio" name="publico" value="1"
                               {{ old('publico', '1') == '1' ? 'checked' : '' }}>
                        Público
                    </label>
                    <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-size:13px;">
                        <input type="radio" name="publico" value="0"
                               {{ old('publico') == '0' ? 'checked' : '' }}>
                        Privado
                    </label>
                </div>
                @error('publico') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div style="display:flex;gap:var(--gap-sm);margin-top:var(--gap-lg);">
                <button type="submit" class="btn btn--primary">Criar Álbum</button>
                <a href="{{ route('albums.index') }}" class="btn btn--ghost">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
