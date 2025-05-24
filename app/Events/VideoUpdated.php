<?php

namespace App\Events;

use App\Models\Video;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VideoUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

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
        return 'video.updated';
    }
}