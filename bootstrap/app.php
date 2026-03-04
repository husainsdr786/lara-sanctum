<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        // No custom auth alias needed in Laravel 11
    })

    ->withExceptions(function (Exceptions $exceptions) {

        // 🔐 Handle Unauthenticated Requests
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Invalid or missing token..',
            ], 401);
        });

        // 💥 Handle All Other Exceptions
        $exceptions->render(function (\Throwable $e, $request) {

            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => config('app.debug')
                        ? $e->getMessage()
                        : 'Server Error',
                ], 500);
            }
        });

    })
    ->create();