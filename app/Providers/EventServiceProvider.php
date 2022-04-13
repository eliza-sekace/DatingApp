<?php

namespace App\Providers;

use App\Events\MatchEvent;
use App\Listeners\MatchListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MatchEvent::class => [
            MatchListener::class
        ]
    ];


    public function boot()
    {

    }
}
