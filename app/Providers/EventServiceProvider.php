<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
     protected $listen = [
        \Illuminate\Auth\Events\Login::class => [
        \App\Listeners\UpdateSessionUserId::class,
        \App\Listeners\AssignDepartmentRole::class,
        ],
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
