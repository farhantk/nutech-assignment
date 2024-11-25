<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\View\Compilers\BladeCompiler;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\AuthMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'guest'=>GuestMiddleware::Class,
            'auth'=>AuthMiddleware::Class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();