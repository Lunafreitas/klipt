{{--
    Edição de perfil do usuário autenticado — nome, e-mail e senha.
    Usa o ProfileController padrão do Breeze/Laravel.
--}}

@extends('layouts.app')
@include('layouts.navigation')
@section('title', 'Meu Perfil')
@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Conta ]</p>
            <h1 class="page-header__title">Meu Perfil</h1>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:var(--gap-lg);max-width:900px;">

        {{-- Seção: informações do perfil --}}
        <div class="form-card">
            <h2 style="font-size:14px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:var(--gap-lg);padding-bottom:var(--gap-md);border-bottom:2px solid var(--c-ink);">
                Informações
            </h2>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PATCH')

                <div class="form-group">
                    <label class="form-label" for="name">Nome</label>
                    <input id="name" type="text" name="name"
                           class="form-control" value="{{ old('name', auth()->user()->name) }}"
                           required maxlength="255">
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">E-mail</label>
                    <input id="email" type="email" name="email"
                           class="form-control" value="{{ old('email', auth()->user()->email) }}"
                           required autocomplete="username">
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn btn--primary">Salvar</button>

                @if(session('status') === 'profile-updated')
                    <p class="text-mono text-sm" style="margin-top:8px;color:green;">✓ Salvo</p>
                @endif
            </form>
        </div>

        {{-- Seção: alteração de senha --}}
        <div class="form-card">
            <h2 style="font-size:14px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:var(--gap-lg);padding-bottom:var(--gap-md);border-bottom:2px solid var(--c-ink);">
                Senha
            </h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="current_password">Senha Atual</label>
                    <input id="current_password" type="password" name="current_password"
                           class="form-control" autocomplete="current-password">
                    @error('current_password', 'updatePassword')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Nova Senha</label>
                    <input id="password" type="password" name="password"
                           class="form-control" autocomplete="new-password">
                    @error('password', 'updatePassword')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirmar Nova Senha</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-control" autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn--primary">Atualizar Senha</button>

                @if(session('status') === 'password-updated')
                    <p class="text-mono text-sm" style="margin-top:8px;color:green;">✓ Senha atualizada</p>
                @endif
            </form>
        </div>
    </div>

    {{-- Seção: excluir conta --}}
    <div style="margin-top:var(--gap-xl);max-width:480px;border:2px solid var(--c-danger);padding:var(--gap-lg);">
        <h2 style="font-size:13px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--c-danger);margin-bottom:var(--gap-md);">
            Zona de Perigo
        </h2>
        <p style="font-size:13px;color:var(--c-ink-muted);margin-bottom:var(--gap-md);">
            A exclusão da conta é permanente. Todos os seus álbuns e fotos serão removidos.
        </p>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf @method('DELETE')
            <div class="form-group">
                <label class="form-label" for="delete_password">Confirme sua senha para continuar</label>
                <input id="delete_password" type="password" name="password"
                       class="form-control">
                @error('password', 'userDeletion')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn--danger"
                    onclick="return confirm('Tem certeza? Esta ação não pode ser desfeita.')">
                Excluir Minha Conta
            </button>
        </form>
    </div>

    <style>
        @media (max-width: 768px) {
            div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns: 1fr !important; }
        }
    </style>

@endsection