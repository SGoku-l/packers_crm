<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Define "api" middleware group
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,  // Sanctum session + token auth
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
         $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // ✅ Put your custom NoCache here (AFTER session + csrf)
            \App\Http\Middleware\NoCache::class,
        ]);
        // $middleware->append(\App\Http\Middleware\NoCache::class);
        // You can also register global middleware here if needed:
        // $middleware->append(\App\Http\Middleware\TrustProxies::class);
        $middleware->alias([
        'nocache' => \App\Http\Middleware\NoCache::class,
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
       ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
