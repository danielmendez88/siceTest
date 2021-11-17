<?php

namespace App\Providers;

use App\Events\SupreEvent;
use App\Events\ValSupreDelegadoEvent;
use App\Events\NotificationEvent;
use App\Listeners\SupreListener;
use App\Listeners\ValSupreDelegadoListener;
use App\Listeners\NotificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Event::listen( SupreEvent::class, SupreListener::class);
        Event::listen( ValSupreDelegadoEvent::class, ValSupreDelegadoListener::class);
        Event::listen( NotificationEvent::class, NotificationListener::class);

        //
    }
}
