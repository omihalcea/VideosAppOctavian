<?php

namespace App\Listeners;

use App\Events\VideoCreated;
use App\Notifications\VideoCreatedNotification as VideoCreatedNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class SendVideoCreatedNotification
{
    public function handle(VideoCreated $event): void
    {
        // Enviar la notificació als usuaris administradors
        $admins = User::where('super_admin', true)->get();

        if ($admins->count() > 0) {
            Notification::send($admins, new VideoCreatedNotification($event->video));
        }
    }
}
