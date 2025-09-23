<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SwaggerBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cibler seulement les routes Swagger
        if ($request->is('api/documentation') || $request->is('docs') || $request->is('docs/*') || $request->is('api-docs.json')) {
            $username = env('SWAGGER_USER', 'admin');
            $password = env('SWAGGER_PASSWORD', 'secret');

            if (
                !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
                $_SERVER['PHP_AUTH_USER'] !== $username || $_SERVER['PHP_AUTH_PW'] !== $password
            ) {

                header('WWW-Authenticate: Basic realm="Swagger Documentation"');
                abort(401, 'Non autorisé');
            }
        }
        return $next($request);
    }
}
