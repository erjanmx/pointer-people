<?php

namespace Tests\Unit;

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
}
