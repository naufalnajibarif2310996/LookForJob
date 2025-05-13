<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(
        basePath: dirname(__DIR__)
    )
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Tambahkan middleware global di sini jika diperlukan
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tambahkan konfigurasi penanganan exception di sini jika diperlukan
    })
    ->create();