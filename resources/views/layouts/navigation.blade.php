    {{-- NAVEGAÇÃO PRINCIPAL --}}
    <nav class="nav">
        <div class="nav__inner">
            {{-- Logotipo --}}
            <a href="{{ route('public.index') }}" class="nav__logo">
                Klipt<span>/</span>
            </a>

            {{-- Links: seção pública --}}
            <ul class="nav__links">
                <a href="{{ route('public.index') }}"
                   class="{{ request()->routeIs('public.index') ? 'active' : '' }}">
                    Galeria
                </a>

                {{-- Links autenticados --}}
                @auth
                {{-- Links exclusivos do administrador --}}
                @if(auth()->user()->is_admin)
                    <span class="nav__sep"></span>
                    <a href="{{ route('tags.index') }}"
                       class="{{ request()->routeIs('tags.*') ? 'active' : '' }} hide-mobile">
                        Tags
                    </a>
                    <a href="{{ route('usuarios.index') }}"
                       class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }} hide-mobile">
                        Usuários
                    </a>
                    <span class="badge-admin">Admin</span>
                    @else
                    {{-- Links dos usuarios --}}
                    <span class="nav__sep"></span>
                    <a href="{{ route('albums.index') }}"
                       class="{{ request()->routeIs('albums.*') ? 'active' : '' }}">
                        Álbuns
                    </a>
                    <a href="{{ route('fotos.index') }}"
                       class="{{ request()->routeIs('fotos.*') ? 'active' : '' }} hide-mobile">
                        Fotos
                    </a>

                    @endif
                @endauth
            </ul>

            {{-- Área direita: perfil / login --}}
            @auth
                <div class="flex items-center gap-sm" style="margin-left:auto; flex-shrink:0;">
                    <a href="{{ route('profile.edit') }}"
                       style="font-size:11px;font-weight:500;letter-spacing:0.08em;color:#AAA;text-decoration:none;text-transform:uppercase;">
                        {{ Str::limit(auth()->user()->name, 14) }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn--ghost btn--sm"
                                style="border-color:#444;color:#AAA;">
                            Sair
                        </button>
                    </form>
                </div>
            @else
                <div class="flex gap-sm" style="margin-left:auto; flex-shrink:0;">
                    <a href="{{ route('login') }}" class="btn btn--ghost btn--sm" style="border-color:#444;color:#AAA;">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn--primary btn--sm">
                        Registrar
                    </a>
                </div>
            @endauth
        </div>
    </nav>
