<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use Tests\TestCase as TestsTestCase;

class MusicTest extends TestsTestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_search_music_success()
    {
        $uri = '/music/search';

        $response = $this->get($uri . "?q=Joji die for you");

        $response->assertStatus(200);
    }

    public function test_add_my_songs_to_a_book()
    {
        $user = User::factory()->create();

        $this->signIn($user);

        $book = Book::factory()->create();

        $request = [
            'book_id' => $book->id,
            'external_music_id' => 'abc',
            'title' => 'music title'
        ];

        $this->post('book/music', $request)->assertStatus(200)
            ->assertJsonStructure(['success', 'data']);

        $this->assertDatabaseHas('musics', [
            'book_id' => $book->id,
            'external_music_id' => 'abc',
            'title' => 'music title'
        ]);


        $this->assertDatabaseHas('music_fans', [
            'music_id' => $book->id,
            'user_id' => $user->id
        ]);
    }

    public function test_get_particular_music_for_book()
    {
        $book = Book::factory()->create();
    }
}
