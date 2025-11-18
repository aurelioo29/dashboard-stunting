<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// === tambahkan ini ===
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\HandleStorageCors; // Tambahkan ini
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Auth\Middleware\Authenticate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // === GLOBAL MIDDLEWARE ===
        $middleware->use([
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class, // Penting untuk CORS
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        // === WEB MIDDLEWARE GROUP ===
        $middleware->web(append: [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // === API MIDDLEWARE GROUP ===
        $middleware->api(prepend: [
            \Illuminate\Http\Middleware\HandleCors::class, // Tambahkan di API juga
        ]);

        // === ALIAS MIDDLEWARE ===
        $middleware->alias([
            'auth'          => Authenticate::class,
            'role'          => RoleMiddleware::class,
            'auth:sanctum'  => Authenticate::class,
            'sanctum'       => EnsureFrontendRequestsAreStateful::class,
            'cors.storage'  => HandleStorageCors::class, // Tambahkan alias ini
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();