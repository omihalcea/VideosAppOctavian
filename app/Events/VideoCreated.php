<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VideoCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $video;

    /**
     * Crea una nova instància de l'event.
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Determina a quin canal s'enviarà l'event.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('videos');
    }

    public function broadcastWith()
    {
        return [
            'video' => [
                'id' => $this->video->id,
                'title' => $this->video->title,
                'description' => $this->video->description,
                'url' => $this->video->url,
            ]
        ];
    }

    public function broadcastAs(): string
    {
        return 'video.created';
    }
}

