<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testInitialResponseEmpty()
    {
        $response = $this->get('/users');

        $this->assertEquals('{"data":[]}', $response->content());
    }

    /**
     * @return void
     */
    public function testReturnsListForUnauthenticated()
    {
        $attributes = [
            'name' => 'John',
            'email' => 'a@a.a',
            'avatar' => 'http//example.com/john.jpg',
            'bio' => 'Bio',
            'country' => 'NL',
            'skills' => ['skill-1', 'skill-2'],
            'team_name' => 'Team',
            'job_title' => 'Position',

        ];

        User::query()->create($attributes);

        $response = $this->get('/users');

        $response->assertJson([
            "data" => [
                [
                    "id" => 1,
                    "name" => "John",
                    "avatar" => 'http//example.com/john.jpg',
                    "bio" => 'Bio',
                    "email" => null,
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
     * Response contains Email for authenticated users
     *
     * @return void
     */
    public function testReturnsListForAuthenticated()
    {
        $attributes = [
            'name' => 'John',
            'email' => 'a@a.a',
            'avatar' => 'http//example.com/john.jpg',
            'bio' => 'Bio',
            'country' => 'NL',
            'skills' => ['skill-1', 'skill-2'],
            'team_name' => 'Team',
            'job_title' => 'Position',

        ];

        $user = User::query()->create($attributes);

        $response = $this->actingAs($user)->get('/users');

        $response->assertJson([
            "data" => [
                [
                    "id" => 1,
                    "name" => "John",
                    "avatar" => 'http//example.com/john.jpg',
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
}
