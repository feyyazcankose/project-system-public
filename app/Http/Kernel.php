<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        
        'is.admin' => \App\Http\Middleware\Check\IsAdmin::class,
        'is.teacher' => \App\Http\Middleware\Check\IsTeacher::class,
        'is.student' => \App\Http\Middleware\Check\IsStudent::class,
        'is.login' => \App\Http\Middleware\Check\IsLogin::class,
        'is.period' => \App\Http\Middleware\Check\IsPeriod::class,
        'is.assign' => \App\Http\Middleware\Check\IsAssign::class,


        //student
        'is.student.assign' => \App\Http\Middleware\Project\Student\IsAssign::class,
        'is.student.report' => \App\Http\Middleware\Project\Student\IsReport::class,
        'is.student.diss' => \App\Http\Middleware\Project\Student\IsDiss::class,
        'is.student.project' => \App\Http\Middleware\Project\Student\IsProject::class,
        'is.student.period' => \App\Http\Middleware\Project\Student\IsPeriod::class,
        //student Status
        'student.status.project' => \App\Http\Middleware\Project\Student\Status\Project::class,
        'student.status.diss' => \App\Http\Middleware\Project\Student\Status\Diss::class,
        'student.status.report' => \App\Http\Middleware\Project\Student\Status\Report::class,





        'is.teacher.assign' => \App\Http\Middleware\Project\Teacher\IsAssign::class,
        'is.teacher.red' => \App\Http\Middleware\Teacher\red::class,
     

        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
