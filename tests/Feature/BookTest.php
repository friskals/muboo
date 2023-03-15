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
        $this->signIn();

        $author =  Author::factory()->create();

        Storage::fake('images');

        $image = UploadedFile::fake()->image('cover.png', 10, 10);

        $request = [
            'title' => 'book title',
            'author_id' => $author->id,
            'image' => $image,
            'is_published' => 1,
            'released_at' => '2023-03-12'
        ];

        $response = $this->post(SELF::ENDPOINT, $request);

        $response->assertStatus(200);

        Storage::disk('public')->assertExists('images/cover.png');

        $this->assertDatabaseHas('books', ['title' => $request['title']]);

        $this->assertDatabaseHas('book_author', ['book_title' => $request['title'], 'author_id' => $request['author_id']]);

        Storage::disk('public')->delete("images/{$image->name}");
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

        Storage::disk('public')->delete($book->image);
    }

    public function test_update_book_success_with_image()
    {
        $book = Book::factory()->create();

        Storage::fake('images');

        $image = UploadedFile::fake()->image('cover.png', 10, 10);

        $request = ['image' => $image];

        $response = $this->put(self::ENDPOINT . "/{$book->id}", $request);

        $response->assertStatus(200);

        Storage::disk('public')->assertMissing($book->image);

        $book->refresh();

        $this->assertEquals($book->image, "images/$image->name");

        Storage::disk('public')->assertExists($book->image);

        Storage::disk('public')->delete($book->image);
    }

    public function test_detail_book_success()
    {
        $book = Book::factory()->create();

        $response = $this->get(self::ENDPOINT . "/{$book->id}");

        $response->assertStatus(200);

        Storage::disk('public')->delete($book->image);
    }

    public function test_destroy_book_success()
    {
        $book = Book::factory()->create();

        $response = $this->delete(self::ENDPOINT . "/{$book->id}");

        $response->assertStatus(200);

        Storage::disk('public')->assertMissing($book->image);
    }

    public function test_filter_book_success()
    {
        $this->signIn();
        $this->get(self::ENDPOINT )->assertStatus(200);
    }
}
