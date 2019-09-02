<?php

namespace Tests\Unit;

use App\User;
use App\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAll()
    {
        $collection = (new Collection())->getAll();

        $this->assertArrayHasKey('skills', $collection);
        $this->assertArrayHasKey('countries', $collection);
        $this->assertArrayHasKey('jobTitles', $collection);
        $this->assertArrayHasKey('teamNames', $collection);
    }

    public function testGetSkills()
    {
        factory(User::class)->create([
            'skills' => ['Excel', 'Word']
        ]);

        $expected = [
            'Excel' => 'Excel',
            'Word' => 'Word',
        ];

        $this->assertEquals($expected, (new Collection())->getSkills());
    }

    public function testGetJobTitles()
    {
        factory(User::class)->create([
            'job_title' => 'Developer',
        ]);
        factory(User::class)->create([
            'job_title' => 'Developer',
        ]);
        factory(User::class)->create([
            'job_title' => 'HR',
        ]);

        $expected = [
            'Developer' => 'Developer',
            'HR' => 'HR',
        ];

        $this->assertEquals($expected, (new Collection())->getJobTitles());
    }

    public function testGetTeamNames()
    {
        $expected = [
            'Sales' => 'Sales',
            'Finance' => 'Finance',
            'Marketing' => 'Marketing',
            'Development' => 'Development',
            'Internal IT' => 'Internal IT',
            'Investigations' => 'Investigations',
            'Human Resources' => 'Human Resources',
            'Brand Protection' => 'Brand Protection',
            'Office Management' => 'Office Management',
        ];

        $this->assertEquals($expected, (new Collection())->getTeamNames());
    }
}
