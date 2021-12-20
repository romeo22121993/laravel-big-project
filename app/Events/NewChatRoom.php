<?php

namespace App\Events;

use App\Models\Chat\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Chat\ChatRoom;

class NewChatRoom
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatRoom;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( ChatRoom  $chatRoom )
    {
        $this->chatRoom = $chatRoom;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('room-new');
    }

    public function broadcastAs() {
        return 'room.new';
    }

}
