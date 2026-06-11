{{--
    Confirmação de senha antes de ações sensíveis (ex: excluir conta).
--}}
@extends('layouts.guest')
@section('title', 'Confirmar Senha')
@section('content')
    <h1>Confirmar Senha</h1>

    <p style="font-size:13px;color:#5A5A5A;margin-bottom:24px;line-height:1.5;">
        Por segurança, confirme sua senha para continuar.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="password">Senha</label>
            <input id="password" type="password" name="password"
                   class="form-control" required autocomplete="current-password">
            @error('password') <p class="form-error">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="btn btn--primary">Confirmar</button>
    </form>
@endsection