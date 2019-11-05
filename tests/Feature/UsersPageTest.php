<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Response contains Email for authenticated users
     *
     * @return void
     */
    public function testReturnsListForAuthenticated()
    {
        $attributes = [
            'name' => 'John',
            'email' => 'a@a.a',
            'avatar' => 'http://example.com/john.jpg',
            'bio' => 'Bio',
            'country' => 'NL',
            'skills' => ['skill-1', 'skill-2'],
            'team_name' => 'Team',
            'job_title' => 'Position',
        ];

        $user = User::query()->create($attributes);

        $user->markEmailAsVerified();

        $response = $this->actingAs($user)->get('/users');

        $response->assertJson([
            "data" => [
                [
                    "id" => 1,
                    "name" => "John",
                    "avatar" => 'http://example.com/john.jpg',
                    "bio" => 'Bio',
                    "email" => 'a@a.a',
                    "team" => 'Team',
                    "skills" => [
                        'skill-1', 'skill-2'
                    ],
                    "position" => 'Position',
                    "countryCode" => 'NL',
                ],
            ],
        ]);
    }

    /**
     */
    public function testLogWhenUsersRequested()
    {
        $user = factory(User::class)->state('verified')->create();

        Log::shouldReceive('info')->once();

        $this->actingAs($user)->get('/users');
    }
}
