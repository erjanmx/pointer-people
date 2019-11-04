<?php

namespace App\Providers;

use App\Events\UserDeleted;
use Illuminate\Auth\Events\Login as UserLogin;
use Illuminate\Auth\Events\Registered as UserRegistered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegistered::class => [
            SendEmailVerificationNotification::class,
            \App\Listeners\UserRegistered::class,
        ],
        UserDeleted::class => [
            \App\Listeners\UserDeleted::class,
        ],
        UserLogin::class => [
            \App\Listeners\UserLoggedIn::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
