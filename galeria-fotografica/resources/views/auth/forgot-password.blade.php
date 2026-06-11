{{--
    Formulário de solicitação de redefinição de senha.
    Envia link de reset para o e-mail informado.
--}}
@extends('layouts.guest')
@section('title', 'Esqueci a Senha')
@section('content')
    <h1>Recuperar Senha</h1>

    <p style="font-size:13px;color:#5A5A5A;margin-bottom:24px;line-height:1.5;">
        Informe seu e-mail e enviaremos um link para redefinir sua senha.
    </p>

    @if (session('status'))
        <div class="flash-error" style="background:#1A1A1A;">
            ✓ &nbsp;{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">E-mail</label>
            <input id="email" type="email" name="email"
                   class="form-control" value="{{ old('email') }}" required autofocus>
            @error('email') <p class="form-error">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="btn btn--primary">Enviar Link</button>
    </form>

    <div class="guest-links">
        <a href="{{ route('login') }}">← Voltar ao login</a>
    </div>
@endsection
