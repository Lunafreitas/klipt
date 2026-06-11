{{-- Formulário de criação de tag — admin only --}}
@extends('layouts.app')
@section('title', 'Nova Tag')
@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Admin / Tags ]</p>
            <h1 class="page-header__title">Nova Tag</h1>
        </div>
        <a href="{{ route('tags.index') }}" class="btn btn--ghost">← Voltar</a>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('tags.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="nome">Nome da Tag *</label>
                <input id="nome" type="text" name="nome"
                       class="form-control" value="{{ old('nome') }}"
                       required maxlength="255" placeholder="ex: paisagem, urbano, retrato">
                @error('nome') <p class="form-error">{{ $message }}</p> @enderror
            </div>
            <div style="display:flex;gap:var(--gap-sm);margin-top:var(--gap-lg);">
                <button type="submit" class="btn btn--primary">Criar Tag</button>
                <a href="{{ route('tags.index') }}" class="btn btn--ghost">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
