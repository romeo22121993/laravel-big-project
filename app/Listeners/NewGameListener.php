<?php

namespace App\Listeners;

use App\Events\NewGame;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewGameListener
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
     * @param  \App\Events\NewGame  $event
     * @return void
     */
    public function handle(NewGame $event)
    {
        //
    }
}
