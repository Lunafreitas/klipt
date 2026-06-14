@extends('layouts.guest')
@section('title', 'Nova Senha')
@section('content')
    <h1>Nova Senha</h1>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label class="form-label" for="email">E-mail</label>
            <input id="email" type="email" name="email"
                   class="form-control" value="{{ old('email', $request->email) }}" required>
            @error('email') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Nova Senha</label>
            <input id="password" type="password" name="password"
                   class="form-control" required autocomplete="new-password">
            @error('password') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirmar Nova Senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="form-control" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn--primary">Redefinir Senha</button>
    </form>
@endsection
