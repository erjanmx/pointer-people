<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testProfilePageContainsDeleteLink()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertSeeText('Delete my account');
    }
}
