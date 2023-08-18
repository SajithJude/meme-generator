<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Listeners\CustomSendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\BookedwebinarNotification;
use App\Listeners\SendEmailbookedwebinar;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            CustomSendEmailVerificationNotification::class,
        ],
        BookedwebinarNotification::class => [
            SendEmailbookedwebinar::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
