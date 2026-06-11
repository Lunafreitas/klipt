<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Processa a requisição — permite apenas admins passarem.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Rejeita usuários não autenticados ou sem flag de admin
        abort_unless($request->user()?->is_admin, 403, 'Acesso negado. Área restrita a administradores.');

        return $next($request);
    }
}
