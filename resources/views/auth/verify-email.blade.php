@extends('layouts.guest')
@section('title', 'Verificar E-mail')
@section('content')
    <h1>Verificar E-mail</h1>

    <p style="font-size:13px;color:#5A5A5A;margin-bottom:24px;line-height:1.5;">
        Enviamos um link de verificação para o seu e-mail.
        Clique no link para ativar sua conta.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="flash-error" style="background:#1A1A1A;margin-bottom:16px;">
            ✓ &nbsp;Novo link enviado com sucesso.
        </div>
    @endif

    <div style="display:flex;flex-direction:column;gap:12px;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn--primary" style="width:100%;">
                Reenviar Link
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn--ghost" style="width:100%;">
                Sair
            </button>
        </form>
    </div>
@endsection
