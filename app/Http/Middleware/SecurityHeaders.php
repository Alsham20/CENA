<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        /*
        |--------------------------------------------------------------------------
        | STRICT TRANSPORT SECURITY (HSTS)
        |--------------------------------------------------------------------------
        | Activer UNIQUEMENT si HTTPS est fonctionnel partout
        */
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CONTENT SECURITY POLICY (Vue.js sur autre domaine)
        |--------------------------------------------------------------------------
        */
        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' https://cena.bj",
            "style-src 'self' 'unsafe-inline' https://cena.bj",
            "img-src 'self' data:",
            "font-src 'self'",
            "connect-src 'self' https://cena.bj",
            "frame-ancestors 'none'",
            "base-uri 'self'",
            "form-action 'self'"
        ]);

        $response->headers->set('Content-Security-Policy', $csp);

        /*
        |--------------------------------------------------------------------------
        | HEADERS DE SÉCURITÉ COMPLÉMENTAIRES
        |--------------------------------------------------------------------------
        */
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set(
            'Permissions-Policy',
            'geolocation=(), camera=(), microphone=()'
        );

        return $response;
    }
}
