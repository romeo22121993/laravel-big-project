<?php

namespace App\Listeners;

use App\Events\GameOver;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GameOverListener
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
     * @param  \App\Events\GameOver  $event
     * @return void
     */
    public function handle(GameOver $event)
    {
        //
    }
}
