<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testIndexPageRedirectsToIntro()
    {
        $response = $this->get('/');

        $response->assertRedirect('intro');
    }

    /**
     * @return void
     */
    public function testIntroPageHasLoginLink()
    {
        $response = $this->get('/intro');

        $response->assertSeeText('Sign in');
    }

    /**
     * @return void
     */
    public function testAuthenticatedUserCanSeeLogoutLink()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertSeeText('Logout');
    }

    /**
     * @return void
     */
    public function testAuthenticatedUserCanSeeProfileLink()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertSeeText('Profile');
    }

    /**
     * @return void
     */
    public function testAuthenticatedUserCanLogout()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect(route('home'));
    }

    /**
     * @return void
     */
    public function testAuthenticatedCanDeleteHimself()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)->post(route('delete-logout'));

        $this->assertEmpty(User::all());
    }

    /**
     * @return void
     */
    public function testHomePageRedirectsToProfileIfNoEmail()
    {
        $user = factory(User::class)->create([
            'email' => null,
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect('profile');
    }
}
