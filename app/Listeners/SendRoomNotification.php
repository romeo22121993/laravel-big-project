<?php

namespace App\Listeners;

use App\Events\NewChatRoom;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRoomNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewChatRoom  $event
     * @return void
     */
    public function handle(NewChatRoom $event)
    {
        //
    }
}
