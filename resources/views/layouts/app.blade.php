{{--
    Layout principal autenticado — usado por todas as páginas internas.
    Inclui navbar responsiva com acesso diferenciado para admin e usuário comum.
    Identidade visual: monocromático preto/branco, tipografia grotesca pesada,
    espaçamento generoso e estética grunge/industrial inspirada no Lareth Project.
--}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Klipt') }} @hasSection('title') — @yield('title') @endif</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>


    {{-- CONTEÚDO PRINCIPAL --}}
    <main class="main">

        {{-- Flash: mensagem de sucesso --}}
        @if(session('success'))
            <div class="flash flash--success">
                ✓ &nbsp;{{ session('success') }}
            </div>
        @endif

        {{-- Flash: mensagem de erro --}}
        @if(session('error'))
            <div class="flash flash--error">
                ✗ &nbsp;{{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
