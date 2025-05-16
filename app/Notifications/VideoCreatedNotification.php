<?php

namespace App\Notifications;

use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VideoCreatedNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $video;

    /**
     * Create a new notification instance.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nou vídeo creat')
            ->line('S’ha afegit un nou vídeo: ' . $this->video->title)
            ->action('Veure vídeo', url('/videos/' . $this->video->id));
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Nou vídeo creat',
            'message' => 'S’ha afegit un nou vídeo: ' . $this->video->title,
            'video_id' => $this->video->id,
            'video_thumbnail' => $this->video->thumbnail_url,
        ]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Nou vídeo creat',
            'message' => 'S’ha afegit un nou vídeo: ' . $this->video->title,
            'video_id' => $this->video->id,
            'video_thumbnail' => $this->video->thumbnail_url,
        ];
    }

}
