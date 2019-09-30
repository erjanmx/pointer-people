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
    public function testIndexPageReturnsOK()
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

        $response->assertSeeText('Sign in with LinkedIn');
    }

    /**
     * @return void
     */
    public function testLoginLinkRedirectsToLinkedIn()
    {
        $response = $this->get('/login/linkedin');

        $response->assertSeeText('Redirecting to https://www.linkedin.com/oauth/');
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
}
