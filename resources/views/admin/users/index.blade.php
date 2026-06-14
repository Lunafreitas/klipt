@extends('layouts.app')
@include('layouts.navigation')
@section('title', 'Usuários')
@section('content')

    <div class="page-header">
        <div>
            <p class="page-header__eyebrow">[ Admin ]</p>
            <h1 class="page-header__title">Usuários</h1>
        </div>
        
        <p class="text-mono text-sm text-muted">{{ $users->total() }} registros</p>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Perfil</th>
                    <th>Álbuns</th>
                    <th>Fotos</th>
                    <th>Registrado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-mono text-sm text-muted">{{ $user->id }}</td>
                    <td style="font-weight:500;">{{ $user->name }}</td>
                    <td class="text-mono text-sm">{{ $user->email }}</td>
                    <td>
                        @if($user->is_admin)
                            <span class="badge-admin">Admin</span>
                        @else
                            <span style="font-family:var(--f-mono);font-size:10px;color:var(--c-ink-muted);">
                                Usuário
                            </span>
                        @endif
                    </td>
                    <td class="text-mono text-sm">{{ $user->albums_count ?? '—' }}</td>
                    <td class="text-mono text-sm">{{ $user->fotos_count ?? '—' }}</td>
                    <td class="text-mono text-sm text-muted">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                    <td>
                        <div style="display:flex;gap:var(--gap-sm);">
                            <a href="{{ route('usuarios.show', $user) }}" class="btn btn--ghost btn--sm">
                                Ver
                            </a>
                            
                            @if($user->id !== auth()->id())        {{-- Impede que o admin exclua a si mesmo --}}
                                <form method="POST" action="{{ route('usuarios.destroy', $user) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--danger btn--sm"
                                            onclick="return confirm('Excluir o usuário {{ $user->name }}?')">
                                        Excluir
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
