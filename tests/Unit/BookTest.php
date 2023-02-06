<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    private const ENDPOINT = '/admin/books';

    public function test_store_book_success()
    {

        $author =  Author::factory()->create();

        Storage::fake('images');

        $image = UploadedFile::fake()->image('cover.png', 10, 10);

        $request = [
            'title' => 'book title',
            'author_id' => $author->id,
            'author_name' => $author->name,
            'image' => $image,
            'is_published' => 1
        ];

        $response = $this->post(SELF::ENDPOINT, $request);

        $response->assertStatus(200);

        Storage::disk('public')->assertExists('images/cover.png');

        $this->assertDatabaseHas('books', ['title' => $request['title'], 'author_id' => $request['author_id']]);
    }

    public function test_update_book_success_without_image()
    {
        $book = Book::factory()->create();

        $new_author = Author::factory()->create();

        $request = [
            'title' => 'updated title',
            'author_id' => $new_author->id,
            'author_name' => $new_author->name
        ];

        $response = $this->put(self::ENDPOINT . "/{$book->id}", $request);

        $response->assertStatus(200);

        $book->refresh();

        $this->assertEquals($request['title'], $book->title);
        $this->assertEquals($new_author->id, $book->author_id);
        $this->assertEquals($new_author->name, $book->author_name);

        Storage::disk('public')->assertExists($book->image);
    }
}
