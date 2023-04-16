<?php

namespace Tests\Feature\API;

use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Content;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;
    public function test_successfully_get_content_and_its_reviews()
    {
        $this->signIn();

        $content = Content::factory()->create();

        $this->get('/api/book/' . $content->book_id)->assertStatus(200)
            ->assertJsonStructure(['success', 'book', 'reviews']);
    }
}
