<?php

namespace App\Events;

use App\Models\Series;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SeriesCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $series;

    public function __construct(Series $series)
    {
        $this->series = $series;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('series');
    }

    public function broadcastWith()
    {
        return [
            'series' => [
                'id' => $this->series->id,
                'title' => $this->series->title,
                'description' => $this->series->description,
            ]
        ];
    }

    public function broadcastAs(): string
    {
        return 'series.created';
    }
}