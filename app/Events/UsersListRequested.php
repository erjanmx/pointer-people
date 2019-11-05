<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class UsersListRequested
{
    use SerializesModels;

    /**
     * @var string
     */
    public $requestedBy;

    /**
     * UsersListRequested constructor.
     * @param string $requestedBy
     */
    public function __construct(string $requestedBy)
    {
        $this->requestedBy = $requestedBy;
    }
}
