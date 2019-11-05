<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class UsersListRequested
{
    /**
     * Handle the event.
     *
     * @param \App\Events\UsersListRequested $event
     * @return void
     */
    public function handle(\App\Events\UsersListRequested $event)
    {
        $key = 'users-list-' . $event->requestedBy;

        if (!Cache::has($key)) {
            $ttl = env('USERS_LIST_CACHE_TTL', 60);

            Cache::put($key, 1, $ttl);

            Log::info('Users list requested by ' . $event->requestedBy);
        }
    }
}
