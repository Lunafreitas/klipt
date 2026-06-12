{{-- Formulário de edição de tag — admin only --}}

@extends('layouts.app')
@include('layouts.navigation')
@section('title', 'Editar Tag: ' . $tag->nome)
@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Admin / Tags ]</p>
            <h1 class="page-header__title">Editar Tag</h1>
        </div>
        <a href="{{ route('tags.index') }}" class="btn btn--ghost">← Voltar</a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('tags.update', $tag) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label" for="nome">Nome da Tag *</label>
                <input id="nome" type="text" name="nome"
                       class="form-control" value="{{ old('nome', $tag->nome) }}"
                       required maxlength="255">
                @error('nome') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div style="display:flex;gap:var(--gap-sm);margin-top:var(--gap-lg);">
                <button type="submit" class="btn btn--primary">Salvar</button>
                <a href="{{ route('tags.index') }}" class="btn btn--ghost">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
