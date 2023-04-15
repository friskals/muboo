<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Category;
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

        $this->get(self::ENDPOINT . "/create")->assertStatus(200);

        $author =  Author::factory()->create();

        Storage::fake('images');

        $image = UploadedFile::fake()->image('cover.png', 10, 10);

        $category = Category::factory()->create();
        
        $request = [
            'title' => 'book title',
            'author_id' => $author->id,
            'image' => $image,
            'is_published' => 1,
            'released_date' => '2023-03-12',
            'category_id' => $category->id,
            'excerpts' => 'lorem ipsum'
        ];

        $this->post(SELF::ENDPOINT, $request)->assertRedirect(route('books.index'));

        Storage::disk('public')->assertExists('images/cover.png');

        $this->assertDatabaseHas('books', ['title' => $request['title']]);

        $this->assertDatabaseHas('book_author', ['book_title' => $request['title'], 'author_id' => $request['author_id']]);

        Storage::disk('public')->delete("images/{$image->name}");
    }

    public function test_update_book_success_without_image()
    {
        $this->signIn();

        $bookAuthor = BookAuthor::factory()->create();

        $new_author = Author::factory()->create();

        $request = [
            'title' => 'updated title',
            'author_id' => $new_author->id         
        ];

        $this->put(self::ENDPOINT . "/{$bookAuthor->book_id}", $request)->assertRedirect(route('books.index'));

        $updatedBook = Book::find($bookAuthor->book_id);

        $this->assertDatabaseHas('book_author', ['author_name' => $new_author->name,'author_id' => $new_author->id]);

        $this->assertEquals($request['title'], $updatedBook->title); 

        Storage::disk('public')->assertExists($bookAuthor->image);

        Storage::disk('public')->delete($bookAuthor->image);
    }

    public function test_update_book_success_with_image()
    {
        $this->signIn();

        $book = BookAuthor::factory()->create();
 
        $this->get(self::ENDPOINT."/{$book->book_id}/edit")->assertStatus(200);

        Storage::fake('images');

        $image = UploadedFile::fake()->image('cover.png', 10, 10);

        $request = ['image' => $image];

        $this->put(self::ENDPOINT . "/{$book->book_id}", $request)->assertRedirect(route('books.index'));

        Storage::disk('public')->assertMissing($book->image);

        $updatedBook = Book::find($book->book_id);

        $this->assertEquals($updatedBook->image, "images/$image->name");

        Storage::disk('public')->assertExists($updatedBook->image);

        Storage::disk('public')->delete($updatedBook->image);
    }

    public function test_detail_book_success()
    {
        $this->signIn();

        $book = Book::factory()->create();

        $response = $this->get(self::ENDPOINT . "/{$book->id}")->assertStatus(200);

        Storage::disk('public')->delete($book->image);
    }

    public function test_destroy_book_success()
    {
        $this->signIn();

        $book = Book::factory()->create();

        $this->delete(self::ENDPOINT . "/{$book->id}")->assertRedirect(route('books.index'));

        Storage::disk('public')->assertMissing($book->image);
    }

    public function test_filter_book_success()
    {
        $this->signIn();

        $this->get(self::ENDPOINT)->assertStatus(200);

        $book = Book::factory()->create();

        $filter = [
            'id' => 1,
            'title' => $book->title
        ];

        $arrayKeys = array_keys($filter);

        for ($i = 0; $i < count($arrayKeys); $i++) {
            $query = $filter[$arrayKeys[$i]];
            $this->followingRedirects()->post(self::ENDPOINT . '/filter-book', [$arrayKeys[$i] => $query])
                ->assertStatus(200);
        }
    }
}
