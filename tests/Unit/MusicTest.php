<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\TestCase as TestsTestCase;

class MusicTest extends TestsTestCase
{
    private const ENDPOINT = 'api/music/search';
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_search_music_success()
    {
        $request = ['q' => 'queen i want to break free'];

        $response = $this->get(self::ENDPOINT."?q=Joji die for you");

        $response->assertStatus(200);
    }
}
