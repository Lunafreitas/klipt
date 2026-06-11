<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Configuração da Aplicação — Klipt
|--------------------------------------------------------------------------
|
| Registra middlewares, aliases e configurações de exceção.
| O alias 'admin' mapeia para AdminMiddleware, usado nas rotas administrativas.
|
*/

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        /*
         * Alias de middleware:
         *   'admin' → AdminMiddleware: verifica is_admin = 1
         * Aplicado nas rotas de gerenciamento de tags e usuários.
         */
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Configurações de exceção padrão do Laravel
    })
    ->create();
