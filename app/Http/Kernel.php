<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

    ];
    protected $routeMiddleware = [
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'user' => \App\Http\Middleware\UserMiddleware::class,
];
protected $middleware = [
    \Illuminate\Http\Middleware\HandleCors::class,

];



}
