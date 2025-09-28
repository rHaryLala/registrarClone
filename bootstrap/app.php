<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
        ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'dean' => \App\Http\Middleware\DeanMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'student' => \App\Http\Middleware\StudentMiddleware::class,
            'teacher' => \App\Http\Middleware\TeacherMiddleware::class,
            'employe' => \App\Http\Middleware\EmployeeMiddleware::class,
            'parent' => \App\Http\Middleware\ParentMiddleware::class,
            'accountant' => \App\Http\Middleware\AccountantMiddleware::class,
            'setlocale' => \App\Http\Middleware\SetLocale::class,
            'multimedia' => \App\Http\Middleware\MultimediaMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
