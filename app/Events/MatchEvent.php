<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $match;

    public function __construct(User $match)
    {
        $this->match = $match;
    }


    public function getMatch(): User
    {
        return $this->match;
    }

}
