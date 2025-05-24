<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VideoDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoTitle;
    public $videoId;

    public function __construct(string $videoTitle, int $videoId)
    {
        $this->videoTitle = $videoTitle;
        $this->videoId = $videoId;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('videos');
    }

    public function broadcastWith()
    {
        return [
            'video' => [
                'id' => $this->videoId,
                'title' => $this->videoTitle,
            ]
        ];
    }

    public function broadcastAs(): string
    {
        return 'video.deleted';
    }
}