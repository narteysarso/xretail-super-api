<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewStaffRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $staff;
    public $user;
    public $password;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $staff, $password)
    {
        $this->user = $user;
        $this->staff = $staff;
        $this->password = $password;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
