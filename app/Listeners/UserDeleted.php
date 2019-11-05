<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

class UserDeleted
{
    /**
     * Handle the event.
     *
     * @param \App\Events\UserDeleted $event
     * @return void
     */
    public function handle(\App\Events\UserDeleted $event)
    {
        Log::info('User removed', $event->user->toArray());
    }
}
