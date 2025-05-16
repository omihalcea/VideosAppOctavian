<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\VideoCreated;
use App\Listeners\SendVideoCreatedNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Els listeners registrats per a esdeveniments.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        VideoCreated::class => [
            SendVideoCreatedNotification::class,
        ],
    ];


    /**
     * Registra qualsevol servei d'esdeveniments.
     */
    public function boot(): void
    {
        //
    }
}
