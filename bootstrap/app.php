<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdminMiddleware::class, 
            // <<< TAMBAHKAN BARIS INI >>>
            'ensure_member' => \App\Http\Middleware\EnsureMember::class, 
        ]);
    })
    
    // Hapus atau gabungkan bagian withMiddleware kedua yang kosong, 
    // karena alias sudah didaftarkan di atas.
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();