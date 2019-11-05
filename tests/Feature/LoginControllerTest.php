<?php

namespace Tests\Feature;

use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testRedirectToProvider()
    {
        Socialite::shouldReceive('driver')
            ->once()
            ->with('linkedin');

        $this->get('/login/linkedin');
    }
}
