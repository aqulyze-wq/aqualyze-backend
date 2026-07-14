<?php
// ================================================================
// Nama Sistem  : Aqualyze - Smart Water Monitoring System
// Author       : Refan Rustoni Putra(10824005), Andini Putri Yani(10824011)
// Versi        : 1.3.0
// Tahun        : 2026
// Ownership    : Capstone Project - Universitas
// Deskripsi    : Sistem monitoring kualitas air berbasis IoT
//                dengan API Laravel sebagai backend.
// ================================================================

// ======================= Library ================================

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\AdminMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        // Alias Middleware
        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {

        //

    })

    ->create();
