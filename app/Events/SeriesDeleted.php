<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SeriesDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $seriesTitle;
    public $seriesId;

    public function __construct(string $seriesTitle, int $seriesId)
    {
        $this->seriesTitle = $seriesTitle;
        $this->seriesId = $seriesId;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('series');
    }

    public function broadcastWith()
    {
        return [
            'series' => [
                'id' => $this->seriesId,
                'title' => $this->seriesTitle,
            ]
        ];
    }

    public function broadcastAs(): string
    {
        return 'series.deleted';
    }
}