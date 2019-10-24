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

        $response = $this->actingAs($user)->get(route("profile"));

        $response->assertSeeText("Delete my account");
    }

    /**
     * @return void
     */
    public function testProfilePageContainsEmailForm()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route("profile"));

        $response->assertSee(
            '<input class="form-control" name="email" type="text" value="' . $user->email
        );
    }
}
