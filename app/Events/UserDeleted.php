<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userName;
    public $userId;

    public function __construct(string $userName, int $userId)
    {
        $this->userName = $userName;
        $this->userId = $userId;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('users');
    }

    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->userId,
                'name' => $this->userName,
            ]
        ];
    }

    public function broadcastAs(): string
    {
        return 'user.deleted';
    }
}