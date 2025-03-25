<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AccessPermission;
use App\Http\Middleware\Impersonate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Đăng ký middleware toàn cục (Global Middleware)
        // $middleware->append(AccessPermission::class); // se ap dung cho tat ca cac route
        $middleware->append(Impersonate::class);

        // Đăng ký middleware bằng alias
        $middleware->alias([
            'auth.roles' => AccessPermission::class,
            'impersonate' => Impersonate::class,
        ]);

        // $middleware->alias([
        //     'impersonate' => Impersonate::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
